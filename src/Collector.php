<?php

namespace Anper\Predis\CommandCollector;

/**
 * Class Collector
 * @package Anper\Predis\CommandCollector
 */
class Collector
{
    /**
     * @var Profile[]
     */
    protected $profiles = [];

    /**
     * @return Profile[]
     */
    public function getProfiles(): array
    {
        return $this->profiles;
    }

    /**
     * @param Profile $profile
     */
    public function __invoke(Profile $profile): void
    {
        $this->profiles[] = $profile;
    }
}
