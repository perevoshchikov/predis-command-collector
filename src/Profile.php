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
        return \implode(' ', \array_map(function ($arg) {
            return $this->formatArg($arg);
        }, $args));
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    protected function formatArg($value): string
    {
        $type = \mb_strtolower(\gettype($value));

        switch ($type) {
            case 'integer':
            case 'double':
                return (string) $value;
            case 'boolean':
                return $value ? 'true' : 'false';
            case 'null':
                return 'null';
            case 'string':
                return \sprintf('"%s"', \addslashes($value));
            case 'object':
                return \sprintf('object (%s)', \get_class($value));
            case 'array':
                return \sprintf('array (%d)', \count($value));
            case 'resource':
                return \sprintf('resource (%s)', \get_resource_type($value));
            default:
                return '';
        }
    }
}
