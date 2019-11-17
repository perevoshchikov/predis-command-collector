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
        switch (\gettype($value)) {
            case 'integer':
            case 'double':
                return (string) $value;
            case 'boolean':
                return $value ? 'true' : 'false';
            case 'null':
                return 'null';
            case 'string':
                if (\preg_match('/["\'\s\\\\]/', $value)) {
                    return \sprintf('"%s"', \addslashes($value));
                }

                return $value;
            case 'object':
            case 'array':
            case 'resource':
            default:
                return '';
        }
    }
}
