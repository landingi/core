<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\InfluxDb;

use PHPUnit\Framework\TestCase;

class GuzzleInfluxDbClientTest extends TestCase
{
    /** @var GuzzleInfluxDbClient */
    private $client;

    protected function setUp()
    {
        $this->client = new GuzzleInfluxDbClient();
    }

    public function testGetBodyWithTagsAndFields(): void
    {
        $this->assertEquals(
            'measurement,tag_key=tag_value field_key="field_value"',
            $this->client->getBody(
                'measurement',
                ['tag_key' => 'tag_value'],
                ['field_key' => 'field_value']
            )
        );
        $this->assertEquals(
            'measurement,tag_key_1=tag_value_1,tag_key_2=tag_value_2 field_key_1="field_value_1",field_key_2="field_value_2"',
            $this->client->getBody(
                'measurement',
                [
                    'tag_key_1' => 'tag_value_1',
                    'tag_key_2' => 'tag_value_2',
                ],
                [
                    'field_key_1' => 'field_value_1',
                    'field_key_2' => 'field_value_2',
                ],
            )
        );
    }

    public function testGetBodyWithoutFields(): void
    {
        $this->assertEquals(
            'measurement,tag_key=tag_value field="value"',
            $this->client->getBody(
                'measurement',
                ['tag_key' => 'tag_value']
            )
        );
        $this->assertEquals(
            'measurement,tag_key_1=tag_value_1,tag_key_2=tag_value_2 field="value"',
            $this->client->getBody(
                'measurement',
                [
                    'tag_key_1' => 'tag_value_1',
                    'tag_key_2' => 'tag_value_2',
                ],
            )
        );
    }

    public function testGetBodyWithoutTags(): void
    {
        $this->assertEquals(
            'measurement field="value"',
            $this->client->getBody('measurement')
        );
        $this->assertEquals(
            'measurement field_key="field_value"',
            $this->client->getBody(
                'measurement',
                [],
                ['field_key' => 'field_value']
            )
        );
        $this->assertEquals(
            'measurement field_key_1="field_value_1",field_key_2="field_value_2"',
            $this->client->getBody(
                'measurement',
                [],
                [
                    'field_key_1' => 'field_value_1',
                    'field_key_2' => 'field_value_2',
                ]
            )
        );
    }

    public function testNumericFieldValue(): void
    {
        $this->assertEquals(
            'measurement field_key=123',
            $this->client->getBody(
                'measurement',
                [],
                ['field_key' => '123']
            )
        );
    }
}
