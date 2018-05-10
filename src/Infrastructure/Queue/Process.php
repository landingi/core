<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Queue;

class Process
{
    private $transport;
    private $extensions;
    private $timeLimit;
    private $processStart;

    public function __construct(Transport $transport, array $extensions = [], int $limitInSeconds = 0)
    {
        $this->transport = $transport;
        $this->extensions = $extensions;
        $this->timeLimit = $limitInSeconds;
    }

    public function process(\Closure $consumer) : void
    {
        $this->processStart = time();

        while (true) {
            foreach ($this->transport->getMessages() as $message) {
                try {
                    if ($this->isTimeLimitReached()) {
                        return;
                    }

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

            if ($this->isTimeLimitReached()) {
                return;
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

    private function isTimeLimitReached() : bool
    {
        if (!$this->timeLimit) {
            return false;
        }

        return time() >= $this->processStart + $this->timeLimit;
    }
}
