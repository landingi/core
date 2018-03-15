<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue;

class Process
{
    private $transport;
    private $extensions;

    public function __construct(Transport $transport, array $extensions = [])
    {
        $this->transport = $transport;
        $this->extensions = $extensions;
    }

    public function process(\Closure $consumer) : void
    {
        while (true) {
            foreach ($this->transport->getMessages() as $message) {
                try {
                    $this->onProcessStart();
                    $consumer($message);
                    $this->transport->remove($message);
                } catch (Exception\LimitReached $e) {
                    return;
                } catch (Exception\IgnoreException $e) {
                    $this->transport->remove($message);
                } catch (Exception\RetryException $e) {
                    if ($message->isLooped()) {
                        $this->onExceptionThrown($e->getPrevious(), $message);
                        $this->transport->remove($message);
                    } else {
                        $this->transport->retry($message);
                    }
                } catch (\Throwable $e) {
                    $this->onExceptionThrown($e, $message);
                    $this->transport->remove($message);
                }
            }
        }
    }

    private function onProcessStart() : void
    {
        array_walk($this->extensions, function (Extension $extension) {
            $extension->onProcessStart();
        });
    }

    private function onExceptionThrown(\Throwable $exception, Message $message) : void
    {
        array_walk($this->extensions, function (Extension $extension) use ($exception, $message) {
            $extension->onExceptionThrown($exception, $message);
        });
    }
}
