<?php

namespace Anper\Predis\CommandCollector;

use Anper\CallableAggregate\CallableAggregateInterface;
use Predis\Command\CommandInterface;
use Predis\Command\Processor\ProcessorInterface;

/**
 * Class Processor
 * @package Anper\Predis\CommandCollector
 */
class Processor implements ProcessorInterface
{
    /**
     * @var CallableAggregateInterface
     */
    protected $collectors;

    /**
     * @param CallableAggregateInterface $collectors
     */
    public function __construct(CallableAggregateInterface $collectors)
    {
        $this->collectors = $collectors;
    }

    /**
     * @inheritDoc
     */
    public function process(CommandInterface $command): void
    {
        \call_user_func($this->collectors, $command);
    }
}
