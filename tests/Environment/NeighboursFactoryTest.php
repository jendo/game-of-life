<?php
namespace GameOfLife\Tests\Environment;

use GameOfLife\Environment\Cell;
use GameOfLife\Environment\CellNeighbours;
use GameOfLife\Environment\NeighboursFactory;
use GameOfLife\Environment\WorldState;
use Mockery;
use PHPUnit\Framework\TestCase;

class NeighboursFactoryTest extends TestCase
{
    const SPECIES_X = 'X';
    const SPECIES_Y = 'Y';
    const AlL_SPECIES = [
        self::SPECIES_X,
        self::SPECIES_Y,
    ];

    public function testShouldReturnCorrectInstance()
    {
        $factory = new NeighboursFactory();
        $neighbours = $factory->createNeighbours(new Cell(0, 0), new WorldState(1, 0, 0, []));

        $this->assertInstanceOf(CellNeighbours::class, $neighbours);
    }

    /**
     * @dataProvider cellNeighboursProvider
     *
     * @param Cell $cell
     * @param WorldState $worldState
     * @param array $expectedNeighbours
     */
    public function testShouldReturnCorrectNeighbours(Cell $cell, WorldState $worldState, array $expectedNeighbours)
    {
        $factory = new NeighboursFactory();
        $cellNeighbours = $factory->createNeighbours($cell, $worldState);

        $this->assertSame($expectedNeighbours, $cellNeighbours->getNeighbours());
    }

    /**
     * @return array
     */
    public function cellNeighboursProvider(): array
    {
        $wordState = $this->createWordState();
        $cells = $wordState->getCells();

        return [
            [
                'cell' => $cells[0][0],
                'wordState' => $wordState,
                'expectedNeighbours' => [
                    $cells[0][1],
                    $cells[1][0],
                    $cells[1][1],
                ],
            ],
            [
                'cell' => $cells[1][1],
                'wordState' => $wordState,
                'expectedNeighbours' => [
                    $cells[0][0],
                    $cells[0][1],
                    $cells[0][2],
                    $cells[1][0],
                    $cells[1][2],
                    $cells[2][0],
                    $cells[2][1],
                    $cells[2][2],
                ],
            ],
        ];
    }

    /**
     * @return WorldState
     */
    private function createWordState(): WorldState
    {
        $cells = [];

        $cells[0][0] = new Cell(0, 0);
        $cells[1][0] = new Cell(1, 0);
        $cells[2][0] = new Cell(2, 0);
        $cells[0][1] = new Cell(0, 1);
        $cells[1][1] = new Cell(1, 1, self::SPECIES_X);
        $cells[2][1] = new Cell(2, 1, self::SPECIES_Y);
        $cells[0][2] = new Cell(0, 2);
        $cells[1][2] = new Cell(1, 2);
        $cells[2][2] = new Cell(2, 2);

        return new WorldState(1, count($cells), count(self::AlL_SPECIES), $cells);
    }
}
