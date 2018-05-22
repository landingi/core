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
            try {
                $this->onProcessIterationStart();

                foreach ($this->transport->getMessages() as $message) {
                    try {
                        $this->onMessageProcessingStart();
                        $consumer($message);
                        $this->transport->remove($message);
                    } catch (Exception\LimitReached $e) {
                        return;
                    } catch (Exception\IgnoreException $e) {
                        $this->transport->remove($message);
                    } catch (Exception\RetryException $e) {
                        if ($message->isLooped()) {
                            $this->onMessageProcessingExceptionThrown($e->getPrevious(), $message);
                            $this->transport->remove($message);
                        } else {
                            $this->transport->retry($message);
                        }
                    } catch (\Throwable $e) {
                        $this->onMessageProcessingExceptionThrown($e, $message);
                        $this->transport->remove($message);
                    }
                }
            } catch (Exception\LimitReached $exception) {
                return;
            } catch (\Throwable $e) {
                $this->onProcessIterationExceptionThrown($e);
            }
        }
    }

    private function onProcessIterationStart() : void
    {
        array_walk($this->extensions, function (Extension $extension) {
            $extension->onProcessIterationStart();
        });
    }

    private function onMessageProcessingStart() : void
    {
        array_walk($this->extensions, function (Extension $extension) {
            $extension->onMessageProcessingStart();
        });
    }

    private function onMessageProcessingExceptionThrown(\Throwable $exception, Message $message) : void
    {
        array_walk($this->extensions, function (Extension $extension) use ($exception, $message) {
            $extension->onMessageProcessingExceptionThrown($exception, $message);
        });
    }

    private function onProcessIterationExceptionThrown(\Throwable $exception) : void
    {
        array_walk($this->extensions, function (Extension $extension) use ($exception) {
            $extension->onProcessIterationExceptionThrown($exception);
        });
    }
}
