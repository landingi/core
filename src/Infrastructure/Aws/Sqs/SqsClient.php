<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Aws\Sqs;

use Aws\Credentials\CredentialProvider;
use Aws\Sqs\SqsClient as BaseClient;

class SqsClient extends BaseClient
{
    public function __construct(string $region)
    {
        $config = [
            'credentials' => CredentialProvider::ini('sqs', getenv('AWS_CREDENTIALS_PROFILES_FILE')),
            'region' => $region,
            'version' => '2012-11-05'
        ];

        if ($endpoint = getenv('AWS_SQS_ENDPOINT')) {
            $config['endpoint'] = $endpoint;
        }

        parent::__construct($config);
    }
}
