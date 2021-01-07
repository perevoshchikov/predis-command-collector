<?php

namespace Anper\Predis\CommandCollector\Tests;

use Anper\Predis\CommandCollector\Profile;
use PHPUnit\Framework\TestCase;
use Predis\Command\StringSet;

/**
 * Class ProfileTest
 * @package Anper\Predis\CommandCollector\Tests
 */
class ProfileTest extends TestCase
{
    public function testGetCommand(): void
    {
        $command = new StringSet();

        $profile = new Profile($command);
        self::assertSame($command, $profile->getCommand());
    }

    /**
     * @return array
     */
    public function argumentProvider(): array
    {
        return [
            [1, '1'],
            [1.1, '1.1'],
            ['bar', 'bar'],
            ['', '""'],
            ['a"b', '"a\"b"'],
            ['a b', '"a b"'],
            [true, 'true'],
            [false, 'false'],
            [null, 'null'],
            [[1], 'array (1)'],
            [$this, 'object (' . __CLASS__ . ')'],
        ];
    }

    /**
     * @dataProvider argumentProvider
     * @param $given
     * @param string $expected
     */
    public function testGetCommandAsString($given, string $expected): void
    {
        $command = new StringSet();
        $command->setArguments(['foo', $given]);

        $profile = new Profile($command);
        self::assertSame('SET foo ' . $expected, $profile->getCommandAsString());
    }
}
