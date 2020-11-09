<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\InfluxDb;

use GuzzleHttp\Client;

final class GuzzleInfluxDbClient extends Client implements InfluxDbClient
{
    public function __construct()
    {
        parent::__construct([
            'base_uri' => 'http://influx.landingi.internal:8086',
            'headers' => ['Content-Type' => 'application/binary'],
        ]);
    }

    public function write(string $measurement, array $tags = [], array $fields = [], $db = 'application'): void
    {
        $this->post(
            "/write?db=$db",
            ['body' => $this->getBody($measurement, $tags, $fields)]
        );
    }

    public function getBody(string $measurement, array $tags = [], array $fields = []): string
    {
        return "$measurement{$this->tagsToString($tags)} {$this->fieldsToString($fields)}";
    }

    private function tagsToString(array $tags): string
    {
        $tagsString = "";

        foreach ($tags as $name => $value) {
            $tagsString .= ",$name=$value";
        }

        return $tagsString;
    }

    private function fieldsToString(array $fields): string
    {
        if (empty($fields)) {
            return 'field="value"';
        }

        $fieldsString = [];

        foreach ($fields as $name => $value) {
            if (is_numeric($value)) {
                $fieldsString[] = "$name=$value";
            } else {
                $fieldsString[] = "$name=\"$value\"";
            }
        }

        return implode(',', $fieldsString);
    }
}
