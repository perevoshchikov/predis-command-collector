<?php

namespace Anper\Predis\CommandCollector\Tests\Mock;

use Predis\Profile\ProfileInterface;

/**
 * Class ProfileFactory
 * @package Anper\Predis\CommandCollector\Tests\Mock
 */
class ProfileFactory
{
    /**
     * @var ProfileInterface
     */
    protected $profile;

    /**
     * @param ProfileInterface $profile
     */
    public function __construct(ProfileInterface $profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return ProfileInterface
     */
    public function __invoke()
    {
        return $this->profile;
    }
}
