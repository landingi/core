<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\Aws\Sqs;

use Aws\Credentials\CredentialProvider;
use Aws\Sqs\SqsClient as BaseClient;

class SqsClient extends BaseClient
{
    public function __construct(string $region, array $options = [])
    {
        $provider = CredentialProvider::defaultProvider();
        $provider = CredentialProvider::memoize($provider);

        $config = array_merge(
            ['region' => $region, 'version' => '2012-11-05'],
            $options
        );

        if (getenv('AWS_CREDENTIALS_PROFILES_FILE')) {
            $config['credentials'] = CredentialProvider::ini('sqs', getenv('AWS_CREDENTIALS_PROFILES_FILE'));
        }

        if (array_key_exists('credentials', $options) && $config['credentials'] === null) {
            $config['credentials'] = $provider;
        }

        if ($endpoint = getenv('AWS_SQS_ENDPOINT')) {
            $config['endpoint'] = $endpoint;
        }

        parent::__construct($config);
    }
}
