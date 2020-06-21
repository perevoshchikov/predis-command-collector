<?php

namespace Anper\Predis\CommandCollector;

use Predis\ClientInterface;

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
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param ClientInterface $client
     *
     * @throws Exception
     */
    public function __construct(ClientInterface $client)
    {
        register_collector($client, $this, true);

        $this->client = $client;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

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
