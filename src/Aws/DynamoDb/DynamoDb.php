<?php
declare(strict_types=1);

namespace Landingi\Core\Aws\DynamoDb;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;

class DynamoDb
{
    private $sdk;
    private $marshaler;

    public function __construct(DynamoDbClient $sdk, Marshaler $marshaler)
    {
        $this->sdk = $sdk;
        $this->marshaler = $marshaler;
    }

    /**
     * Example:
     * $dynamoDb->getItem(['id' => 2], 'tableName');.
     *
     * @return array|\stdClass|null
     */
    public function getItem(array $key, string $tableName)
    {
        $item = $this->sdk->getItem([
            'TableName' => $tableName,
            'Key' => $this->marshaler->marshalItem($key),
        ]);

        return isset($item['Item']) ? $this->marshaler->unmarshalItem($item['Item']) : null;
    }

    public function updateItem(string $tableName, array $key, array $values): void
    {
        $expressionAttributeNames = [];
        $expressionAttributeValues = [];
        $updateExpression = '';

        foreach ($values as $fieldName => $value) {
            $updateExpression = sprintf('%s#%s = :%s, ', $updateExpression, $fieldName, $fieldName);
            $expressionAttributeValues[sprintf(':%s', $fieldName)] = $this->marshaler->marshalValue($value);
            $expressionAttributeNames[sprintf('#%s', $fieldName)] = $fieldName;
        }

        $this->sdk->updateItem([
            'TableName' => $tableName,
            'Key' => $this->marshaler->marshalItem($key),
            'UpdateExpression' => sprintf('set %s', rtrim($updateExpression, ', ')),
            'ExpressionAttributeValues' => $expressionAttributeValues,
            'ExpressionAttributeNames' => $expressionAttributeNames,
        ]);
    }
}
