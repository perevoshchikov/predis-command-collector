<?php

namespace Anper\Predis\CommandCollector\Tests;

use Anper\CallableAggregate\CallableAggregateInterface;
use Anper\Predis\CommandCollector\Processor;
use PHPUnit\Framework\TestCase;
use Predis\Command\StringSet;

/**
 * Class ProcessorTest
 * @package Anper\Predis\CommandCollector\Tests
 */
class ProcessorTest extends TestCase
{
    public function testCallCollector(): void
    {
        $command = new StringSet();

        $collection = $this->createMock(CallableAggregateInterface::class);
        $collection->expects($this->once())
            ->method('__invoke')
            ->with($command);

        $processor = new Processor($collection);
        $processor->process($command);
    }
}
