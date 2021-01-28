<?php
declare(strict_types=1);

namespace Landingi\Core\Aws\S3;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

final class ClientFactory
{
    public function build(Credentials $credentials, string $region): S3Client
    {
        return new S3Client([
            'credentials' => $credentials,
            'region' => $region,
            'version' => 'latest',
        ]);
    }
}
