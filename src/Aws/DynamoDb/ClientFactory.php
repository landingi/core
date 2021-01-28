<?php
declare(strict_types=1);

namespace Landingi\Core\Aws\DynamoDb;

use Aws\Credentials\Credentials;
use Aws\DynamoDb\DynamoDbClient;

final class ClientFactory
{
    public function build(Credentials $credentials, string $region, string $endpoint): DynamoDbClient
    {

    }
}
