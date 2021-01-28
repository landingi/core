<?php
declare(strict_types=1);

namespace Landingi\Core\Aws\Sqs;

use Aws\Credentials\Credentials;
use Aws\Sqs\SqsClient;

final class ClientFactory
{
    public function build(Credentials $credentials, string $region, string $endpoint): SqsClient
    {
        $config = [
            'credentials' => $credentials,
            'region' => $region,
            'version' => 'latest',
        ];

        if ($endpoint) {
            $config['endpoint'] = $endpoint;
        }

        return new SqsClient($config);
    }
}
