<?php

namespace Anper\Predis\CommandCollector;

use PHPUnit\Framework\TestCase;
use Predis\Command\StringSet;

/**
 * Class TraceableProcessorTest
 * @package Anper\Predis\CommandCollector
 */
class TraceableProcessorTest extends TestCase
{
    public function testCallCollector(): void
    {
        $command = new StringSet();

        $collector = $this->createMock(Collector::class);
        $collector->expects($this->once())
            ->method('__invoke')
            ->with($this->callback(function (Profile $profile) use ($command) {
                $this->assertSame($command, $profile->getCommand());

                return true;
            }));

        $processor = new TraceableProcessor($collector);

        $processor->process($command);
    }
}

class Collector
{
    public function __invoke()
    {
        //
    }
}
