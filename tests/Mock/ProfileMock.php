<?php

namespace Anper\Predis\CommandCollector\Tests\Mock;

use Predis\Profile\RedisProfile;

/**
 * Class ProfileMock
 * @package Anper\Predis\CommandCollector\Mock
 */
class ProfileMock extends RedisProfile
{
    /**
     * @inheritDoc
     */
    protected function getSupportedCommands()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getVersion()
    {
        return 1;
    }
}
