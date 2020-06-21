<?php

namespace Anper\Predis\CommandCollector\Tests\Mock;

use Predis\Profile\ProfileInterface;

/**
 * Class NullProfileMock
 * @package Anper\Predis\CommandCollector\Tests\Mock
 */
class NullProfileMock implements ProfileInterface
{
    /**
     * @inheritDoc
     */
    public function getVersion()
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function supportsCommand($commandID)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function supportsCommands(array $commandIDs)
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function createCommand($commandID, array $arguments = array())
    {
        //
    }
}
