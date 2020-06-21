<?php

namespace Anper\Predis\CommandCollector\Tests;

use Anper\Predis\CommandCollector\Collector;
use Anper\Predis\CommandCollector\Profile;
use PHPUnit\Framework\TestCase;
use Predis\Client;

use function Anper\Predis\CommandCollector\get_collectors;

/**
 * Class CollectorTest
 * @package Anper\Predis\CommandCollector
 */
class CollectorTest extends TestCase
{
    public function testRegister(): void
    {
        $client = new Client();

        $collector1 = new Collector($client);
        $collector2 = new Collector($client);

        $this->assertSame([$collector1, $collector2], get_collectors($client));
    }

    public function testProfile(): void
    {
        $client = new Client();

        $collector = new Collector($client);
        $profile = $this->createMock(Profile::class);
        $collector->__invoke($profile);

        $this->assertEquals([$profile], $collector->getProfiles());
    }

    public function testGetClient(): void
    {
        $client = new Client();
        $collector = new Collector($client);

        $this->assertSame($client, $collector->getClient());
    }
}
