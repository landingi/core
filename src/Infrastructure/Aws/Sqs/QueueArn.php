<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Aws\Sqs;

class QueueArn
{
    private $arn;

    public function __construct(SqsClient $sqs, string $name)
    {
        $prefix = sprintf(
            'https://sqs.%s.amazonaws.com/084824767965',
            $sqs->getRegion()
        );

        if (false === strpos($prefix, (string) $sqs->getEndpoint())) {
            $prefix = (string) $sqs->getEndpoint();
        }

        $this->arn = "$prefix/$name";
    }

    public function __toString() : string
    {
        return $this->arn;
    }
}
