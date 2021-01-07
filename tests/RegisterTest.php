<?php

namespace Anper\Predis\CommandCollector\Tests;

use Anper\Predis\CommandCollector\Processor;
use Anper\Predis\CommandCollector\Tests\Mock\NullProfileMock;
use Anper\Predis\CommandCollector\Tests\Mock\ProfileFactory;
use PHPUnit\Framework\TestCase;
use Predis\Client;
use Anper\Predis\CommandCollector\Exception;
use Predis\ClientInterface;
use Predis\Command\Processor\ProcessorChain;

use function Anper\Predis\CommandCollector\get_collectors;
use function Anper\Predis\CommandCollector\register_collector;

/**
 * Class RegisterTest
 * @package Anper\Predis\CommandCollector\Tests
 */
class RegisterTest extends TestCase
{
    /**
     * @var \Closure
     */
    protected $collector1;

    /**
     * @var \Closure
     */
    protected $collector2;

    protected function setUp(): void
    {
        $this->collector1 = function ($a, $b) {
            //
        };

        $this->collector2 = function ($a) {
            //
        };
    }

    protected function getInvalidClient(): ClientInterface
    {
        return new Client([], [
            'profile' => new ProfileFactory(new NullProfileMock()),
        ]);
    }

    public function testFailedRegister(): void
    {
        $client = $this->getInvalidClient();
        $result = register_collector($client, $this->collector1, false);

        self::assertFalse($result);
        $this->assertNotHasCollector($client, $this->collector1);
    }

    public function testRegisterWithException(): void
    {
        $this->expectException(Exception::class);

        register_collector($this->getInvalidClient(), $this->collector1);
    }

    public function testAppendRegister(): void
    {
        $client = new Client();

        $result1 = register_collector($client, $this->collector1);
        $result2 = register_collector($client, $this->collector2);

        self::assertTrue($result1);
        self::assertTrue($result2);
        self::assertSame([$this->collector1, $this->collector2], get_collectors($client));
        self::assertTrue($this->hasProcessor($client));
    }

    public function testPrependRegister(): void
    {
        $client = new Client();

        register_collector($client, $this->collector1);
        register_collector($client, $this->collector2, true, true);

        self::assertSame([$this->collector2, $this->collector1], get_collectors($client));
        self::assertTrue($this->hasProcessor($client));
    }

    /**
     * @param ClientInterface $client
     *
     * @return bool
     */
    protected function hasProcessor(ClientInterface $client): bool
    {
        $profile = $client->getProfile();
        $processor = $profile->getProcessor();

        if ($processor instanceof ProcessorChain) {
            foreach ($processor->getProcessors() as $p) {
                if ($p instanceof Processor) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param ClientInterface $client
     * @param $collector
     */
    protected function assertHasCollector(ClientInterface $client, $collector): void
    {
        self::assertTrue(
            $this->hasCollector($client, $collector),
            'Collector does not register'
        );
    }

    /**
     * @param ClientInterface $client
     * @param $collector
     */
    protected function assertNotHasCollector(ClientInterface $client, $collector): void
    {
        self::assertFalse(
            $this->hasCollector($client, $collector),
            'Collector already register'
        );
    }

    /**
     * @param ClientInterface $client
     * @param $collector
     *
     * @return bool
     */
    protected function hasCollector(ClientInterface $client, $collector): bool
    {
        foreach (get_collectors($client) as $c) {
            if (\spl_object_hash($c) === \spl_object_hash($collector)) {
                return true;
            }
        }

        return false;
    }
}
