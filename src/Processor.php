<?php

namespace Anper\Predis\CommandCollector;

use Predis\Command\CommandInterface;
use Predis\Command\Processor\ProcessorInterface;

/**
 * Class Processor
 * @package Anper\Predis\CommandCollector
 */
class Processor implements ProcessorInterface
{
    /**
     * @var callable
     */
    protected $collector;

    /**
     * @param callable $collector
     */
    public function __construct(callable $collector)
    {
        $this->collector = $collector;
    }

    /**
     * @inheritDoc
     */
    public function process(CommandInterface $command): void
    {
        \call_user_func($this->collector, new Profile($command));
    }
}
