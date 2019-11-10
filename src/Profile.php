<?php

namespace Anper\Predis\CommandCollector;

use Predis\Command\CommandInterface;

/**
 * Class Profile
 * @package Anper\PredisCollector
 */
class Profile
{
    /**
     * @var CommandInterface
     */
    protected $command;

    /**
     * @param CommandInterface $command
     */
    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
    }

    /**
     * @return CommandInterface
     */
    public function getCommand(): CommandInterface
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getCommandAsString(): string
    {
        return $this->command->getId()
            . ' '
            . $this->formatArguments($this->command->getArguments());
    }

    /**
     * @param array $args
     *
     * @return string
     */
    protected function formatArguments(array $args): string
    {
        return \implode(' ', \array_map(function (string $arg) {
            return \trim($arg) ? $arg : '""';
        }, $args));
    }
}
