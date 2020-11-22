<?php

namespace Anper\Predis\CommandCollector\Tests;

use Anper\Predis\CommandCollector\Collector;
use Anper\Predis\CommandCollector\Profile;
use PHPUnit\Framework\TestCase;

/**
 * Class CollectorTest
 * @package Anper\Predis\CommandCollector
 */
class CollectorTest extends TestCase
{
    public function testProfile(): void
    {
        $collector = new Collector();
        $profile = $this->createMock(Profile::class);
        $collector->__invoke($profile);

        $this->assertEquals([$profile], $collector->getProfiles());
    }
}
