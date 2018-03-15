<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Aws\Sqs;

use Landingi\Shared\Infrastructure\Queue;

class Message implements \JsonSerializable, Queue\Message
{
    private $handle;
    private $body;
    private $receiveCount;

    public function __construct($body, $handle = null, $receiveCount = 1)
    {
        $this->body = $body;
        $this->handle = $handle;
        $this->receiveCount = $receiveCount;
    }

    public function getHandle() : string
    {
        return (string) $this->handle;
    }

    public function getBody() : array
    {
        return $this->body;
    }

    public function isLooped() : bool
    {
        return $this->receiveCount > 10;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->body[$name] ?? null;
    }

    public function isEmpty() : bool
    {
        return null === $this->handle || null === $this->body;
    }

    public function jsonSerialize() : array
    {
        return $this->body;
    }

    public function getFlattenedBody() : array
    {
        $result = [];

        foreach ($this->getBody() as $name => $property) {
            if (is_array($property)) {
                $result[sprintf('item-%s', $name)] = $this->flattenProperty('', $property);
            } else {
                $result['item'][$name] = $property;
            }
        }

        return $result;
    }

    private function flattenProperty($name, $property) : array
    {
        $result = [];

        if (is_array($property)) {
            foreach ($property as $key => $value) {
                if ($name) {
                    $key = sprintf('%s[%s]', $name, $key);
                }

                $result = array_merge($result, $this->flattenProperty($key, $value));
            }
        } else {
            $result[$name] = $property;
        }

        return $result;
    }
}
