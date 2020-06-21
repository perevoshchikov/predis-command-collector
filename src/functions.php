<?php

namespace Anper\Predis\CommandCollector;

use Predis\ClientInterface;
use Predis\Command\Processor\ProcessorChain;
use Predis\Command\Processor\ProcessorInterface;
use Predis\Profile\RedisProfile;

use function Anper\CallableAggregate\aggregator;
use function Anper\CallableAggregate\clear_callbacks;
use function Anper\CallableAggregate\get_callbacks;
use function Anper\CallableAggregate\unregister_callback;

/**
 * @param ClientInterface $client
 * @param callable $collector
 * @param bool $throw
 * @param bool $prepend
 *
 * @return bool
 * @throws \Exception
 */
function register_collector(
    ClientInterface $client,
    callable $collector,
    bool $throw = true,
    bool $prepend = false
): bool {
    $collection = aggregator($client, $created);

    if ($created) {
        try {
            register_processor($client, new Processor($collection));
        } catch (\Exception $exception) {
            if ($throw) {
                throw $exception;
            }

            return false;
        }
    }

    $prepend
        ? $collection->prepend($collector)
        : $collection->append($collector);

    return true;
}

/**
 * @param ClientInterface $client
 * @param callable $collector
 *
 * @return bool
 */
function unregister_collector(ClientInterface $client, callable $collector): bool
{
    return unregister_callback($client, $collector);
}

/**
 * @param ClientInterface $client
 *
 * @return array
 */
function get_collectors(ClientInterface $client): array
{
    return get_callbacks($client);
}

/**
 * @param ClientInterface $client
 *
 * @return int
 */
function clear_collectors(ClientInterface $client): int
{
    return clear_callbacks($client);
}

/**
 * @param ClientInterface $client
 * @param ProcessorInterface $processor
 *
 * @return bool
 * @throws Exception
 * @internal
 */
function register_processor(ClientInterface $client, ProcessorInterface $processor): bool
{
    $profile = $client->getProfile();

    if (!($profile instanceof RedisProfile)) {
        throw new Exception(\sprintf(
            'Client profile must be instance of %s, given %s',
            RedisProfile::class,
            \get_class($profile)
        ));
    }

    $chainProcessor = $profile->getProcessor();

    if (!($chainProcessor instanceof ProcessorChain)) {
        $chainProcessor = $chainProcessor
            ? new ProcessorChain([$chainProcessor])
            : new ProcessorChain();

        $profile->setProcessor($chainProcessor);
    }

    $chainProcessor->add($processor);

    return true;
}
