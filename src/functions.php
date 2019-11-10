<?php

namespace Anper\Predis\CommandCollector;

use Predis\ClientInterface;
use Predis\Command\Processor\ProcessorChain;
use Predis\Profile\RedisProfile;

/**
 * @param ClientInterface $client
 * @param callable $collector
 *
 * @return bool
 */
function register_predis_collector(ClientInterface $client, callable $collector): bool
{
    $profile = $client->getProfile();

    if (($profile instanceof RedisProfile) === false) {
        return false;
    }

    $processor = $profile->getProcessor();

    if (($processor instanceof ProcessorChain) === false) {
        $processor = $processor
            ? new ProcessorChain([$processor])
            : new ProcessorChain();

        $profile->setProcessor($processor);
    }

    $processor->add(new TraceableProcessor($collector));

    return true;
}
