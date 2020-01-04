<?php

namespace Anper\Predis\CommandCollector;

use PHPUnit\Framework\TestCase;
use Predis\Command\StringSet;

/**
 * Class ProfileTest
 * @package Anper\Predis\CommandCollector
 */
class ProfileTest extends TestCase
{
    public function testGetCommand(): void
    {
        $command = new StringSet();

        $profile = new Profile($command);
        $this->assertSame($command, $profile->getCommand());
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
        $this->assertSame('SET foo ' . $expected, $profile->getCommandAsString());
    }
}
