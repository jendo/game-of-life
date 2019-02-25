<?php
namespace GameOfLife\Tests\Environment;

use GameOfLife\Environment\CellState;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CellStateTest extends TestCase
{
    const INVALID_CELL_STATE = 10;
    const NEW_CELL_SPECIES = 'Y';

    public function testShouldThrowExceptionWithInvalidState()
    {
        $this->expectException(InvalidArgumentException::class);
        $state = new CellState(self::INVALID_CELL_STATE);
    }

    public function testIsCellStateStayAlive()
    {
        $state = new CellState(CellState::STAY_ALIVE);

        $this->assertTrue($state->stayAlive());
        $this->assertFalse($state->stayEmpty());
        $this->assertFalse($state->isTerminated());
        $this->assertFalse($state->isArise());
    }

    public function testIsCellStateStayEmpty()
    {
        $state = new CellState(CellState::STAY_EMPTY);

        $this->assertTrue($state->stayEmpty());
        $this->assertFalse($state->stayAlive());
        $this->assertFalse($state->isTerminated());
        $this->assertFalse($state->isArise());
    }

    public function testIsCellStateTerminated()
    {
        $state = new CellState(CellState::TERMINATED);

        $this->assertTrue($state->isTerminated());
        $this->assertFalse($state->stayEmpty());
        $this->assertFalse($state->stayAlive());
        $this->assertFalse($state->isArise());
    }

    public function testIsCellStateArise()
    {
        $state = new CellState(CellState::ARISE, self::NEW_CELL_SPECIES);

        $this->assertTrue($state->isArise());
        $this->assertFalse($state->isTerminated());
        $this->assertFalse($state->stayEmpty());
        $this->assertFalse($state->stayAlive());

        $this->assertSame(self::NEW_CELL_SPECIES, $state->getNewSpecies());
    }
}
