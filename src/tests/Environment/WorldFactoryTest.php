<?php
namespace GameOfLife\Tests\Environment;

use GameOfLife\Environment\NeighboursFactory;
use GameOfLife\Environment\World;
use GameOfLife\Environment\WorldFactory;
use GameOfLife\Environment\WorldState;
use Mockery;
use PHPUnit\Framework\TestCase;

class WorldFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new WorldFactory($this->createNeighboursFactoryMock());
        $instance = $factory->create($this->createWordStateMock());

        $this->assertInstanceOf(World::class, $instance);
    }

    /**
     * @return WorldState
     */
    private function createWordStateMock(): WorldState
    {
        /** @var WorldState $mock */
        $mock = Mockery::mock(WorldState::class);

        return $mock;
    }

    /**
     * @return NeighboursFactory
     */
    private function createNeighboursFactoryMock(): NeighboursFactory
    {
        /** @var NeighboursFactory $mock */
        $mock = Mockery::mock(NeighboursFactory::class);

        return $mock;
    }
}

