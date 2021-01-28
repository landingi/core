<?php
declare(strict_types=1);

namespace Landingi\Core\Aws\Sns;

use Aws\Credentials\Credentials;
use Aws\Sns\SnsClient;

final class ClientFactory
{
    public function build(Credentials $credentials, string $region): SnsClient
    {
        return new SnsClient([
            'credentials' => $credentials,
            'region' => $region,
            'version' => 'latest',
        ]);
    }
}
