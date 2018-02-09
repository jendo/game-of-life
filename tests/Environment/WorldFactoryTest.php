<?php
namespace GameOfLife\Tests\Environment;

use GameOfLife\Environment\NeighboursFactory;
use GameOfLife\Environment\World;
use GameOfLife\Environment\WorldFactory;
use GameOfLife\Environment\WorldState;
use Mockery;
use Mockery\MockInterface;
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
     * @return WorldState|MockInterface
     */
    private function createWordStateMock(): WorldState
    {
        $mock = Mockery::mock(WorldState::class);

        return $mock;
    }

    /**
     * @return NeighboursFactory|MockInterface
     */
    private function createNeighboursFactoryMock(): NeighboursFactory
    {
        $mock = Mockery::mock(NeighboursFactory::class);

        return $mock;
    }
}

