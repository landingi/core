<?php
declare (strict_types=1);

use Landingi\Shared\Infrastructure\Aws\Sqs\Message;
use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    public function testMultiLevelBodyCanBeFlattened() : void
    {
        $message = new Message([
            'foo' => [
                'foo' => ['foo' => 'abc', 'bar' => 'def'],
                'bar' => ['foo' => 'ghi', 'bar' => 'jkl']
            ],
            'bar' => [
                'foo' => ['foo' => 'mno', 'bar' => 'pqr'],
                'bar' => ['foo' => 'stu', 'bar' => 'vwx']
            ]
        ]);

        self::assertEquals(
            [
                'item-foo' => [
                    'foo[foo]' => 'abc',
                    'foo[bar]' => 'def',
                    'bar[foo]' => 'ghi',
                    'bar[bar]' => 'jkl'
                ],
                'item-bar' => [
                    'foo[foo]' => 'mno',
                    'foo[bar]' => 'pqr',
                    'bar[foo]' => 'stu',
                    'bar[bar]' => 'vwx'
                ]
            ],
            $message->getFlattenedBody()
        );
    }

    public function testMessageWithNoBodyIsEmpty() : void
    {
        self::assertTrue((new Message(null))->isEmpty());
    }

    public function testMessageWithNoHandleIsEmpty() : void
    {
        self::assertTrue((new Message(['foo' => 'bar']))->isEmpty());
    }

    public function testBodyPropertyCanBeFetched() : void
    {
        $message = new Message(['foo' => 'bar']);

        self::assertEquals('bar', $message->get('foo'));
    }

    public function testEntireBodyCanBeFetched() : void
    {
        $message = new Message(['foo' => 'bar']);

        self::assertEquals(['foo' => 'bar'], $message->getBody());
    }
}
