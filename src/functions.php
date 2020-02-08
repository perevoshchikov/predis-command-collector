<?php

namespace Anper\Predis\CommandCollector;

use Predis\ClientInterface;
use Predis\Command\Processor\ProcessorChain;
use Predis\Profile\RedisProfile;

/**
 * @param ClientInterface $client
 *
 * @return ProcessorChain|null
 */
function get_predis_chain_processor(ClientInterface $client): ?ProcessorChain
{
    $profile = $client->getProfile();

    if (($profile instanceof RedisProfile) === false) {
        return null;
    }

    $processor = $profile->getProcessor();

    if (($processor instanceof ProcessorChain) === false) {
        $processor = $processor
            ? new ProcessorChain([$processor])
            : new ProcessorChain();

        $profile->setProcessor($processor);
    }

    return $processor;
}

/**
 * @param ClientInterface $client
 * @param callable $collector
 *
 * @return bool
 */
function register_predis_collector(ClientInterface $client, callable $collector): bool
{
    $processor = get_predis_chain_processor($client);

    if ($processor === null) {
        return false;
    }

    $processor->add(new TraceableProcessor($collector));

    return true;
}

/**
 * @param ClientInterface $client
 *
 * @return array
 */
function get_predis_collectors(ClientInterface $client): array
{
    $processor = get_predis_chain_processor($client);

    if ($processor === null) {
        return [];
    }

    $result = [];

    foreach ($processor->getProcessors() as $p) {
        if ($p instanceof TraceableProcessor) {
            $result[] = $p->getCollector();
        }
    }

    return $result;
}
