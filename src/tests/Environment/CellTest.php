<?php
namespace GameOfLife\Tests\Environment;

use GameOfLife\Environment\Cell;
use GameOfLife\Environment\CellNeighbours;
use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{
    const CELL_POS_X = 1;
    const CELL_POS_Y = 1;
    const CELL_SPECIES = 'Y';

    const ANOTHER_CELL_SPECIES = 'X';
    const ANOTHER_CELL_SPECIES_2 = 'Z';

    /**
     * @dataProvider shouldBeLiveCellTerminatedProvider
     *
     * @param CellNeighbours $expectedCellNeighbours
     * @param Cell $expectedEvolvedCell
     */
    public function testShouldBeLiveCellTerminated(CellNeighbours $expectedCellNeighbours, Cell $expectedEvolvedCell)
    {

        $cell = $this->createLiveTestCell();
        $this->assertSame(self::CELL_SPECIES, $cell->getSpecies());

        $actualEvolvedCell = $cell->evolve($expectedCellNeighbours);
        $this->assertEquals($expectedEvolvedCell, $actualEvolvedCell);
    }

    /**
     * @return array
     */
    public function shouldBeLiveCellTerminatedProvider()
    {
        return [
            'live cell will be terminated#1 - not enough live neighbours' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::CELL_SPECIES),
                        new Cell(0, 1),
                        new Cell(0, 2),
                        new Cell(1, 0),
                        new Cell(1, 2),
                        new Cell(2, 0),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedEvolvedCell' => new Cell(self::CELL_POS_X, self::CELL_POS_Y),
            ],
            'live cell will be terminated#2 - too much live neighbours' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::CELL_SPECIES),
                        new Cell(0, 1, self::CELL_SPECIES),
                        new Cell(0, 2, self::CELL_SPECIES),
                        new Cell(1, 0, self::CELL_SPECIES),
                        new Cell(1, 2),
                        new Cell(2, 0),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedEvolvedCell' => new Cell(self::CELL_POS_X, self::CELL_POS_Y),
            ],

            'live cell will be terminated#3 -   not enough live neighbours of same species' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::CELL_SPECIES),
                        new Cell(0, 1, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 2, self::ANOTHER_CELL_SPECIES),
                        new Cell(1, 0, self::ANOTHER_CELL_SPECIES),
                        new Cell(1, 2),
                        new Cell(2, 0),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedEvolvedCell' => new Cell(self::CELL_POS_X, self::CELL_POS_Y),
            ],
        ];
    }

    /**
     * @dataProvider shouldLiveCellStayAliveProvider
     *
     * @param CellNeighbours $expectedCellNeighbours
     * @param Cell $expectedEvolvedCell
     */
    public function testShouldLiveCellStayAlive(CellNeighbours $expectedCellNeighbours, Cell $expectedEvolvedCell)
    {
        $cell = $this->createLiveTestCell();
        $this->assertSame(self::CELL_SPECIES, $cell->getSpecies());

        $actualEvolvedCell = $cell->evolve($expectedCellNeighbours);
        $this->assertEquals($expectedEvolvedCell, $actualEvolvedCell);
    }

    /**
     * @return array
     */
    public function shouldLiveCellStayAliveProvider()
    {
        return [
            'live cell stay alive#1 - two live neighbours of same species' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::CELL_SPECIES),
                        new Cell(0, 1, self::CELL_SPECIES),
                        new Cell(0, 2),
                        new Cell(1, 0),
                        new Cell(1, 2),
                        new Cell(2, 0),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedEvolvedCell' => new Cell(self::CELL_POS_X, self::CELL_POS_Y, self::CELL_SPECIES),
            ],
            'live cell stay alive#2 - three live neighbours of same species' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::CELL_SPECIES),
                        new Cell(0, 1, self::CELL_SPECIES),
                        new Cell(0, 2, self::CELL_SPECIES),
                        new Cell(1, 0),
                        new Cell(1, 2),
                        new Cell(2, 0),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedEvolvedCell' => new Cell(self::CELL_POS_X, self::CELL_POS_Y, self::CELL_SPECIES),
            ],
        ];
    }

    /**
     * @dataProvider shouldEmptyCellStayEmptyProvider
     *
     * @param CellNeighbours $expectedCellNeighbours
     * @param Cell $expectedEvolvedCell
     */
    public function testShouldEmptyCellStayEmpty(CellNeighbours $expectedCellNeighbours, Cell $expectedEvolvedCell)
    {
        $cell = $this->createEmptyTestCell();
        $this->assertNull($cell->getSpecies());

        $actualEvolvedCell = $cell->evolve($expectedCellNeighbours);
        $this->assertEquals($expectedEvolvedCell, $actualEvolvedCell);
    }

    /**
     * @return array
     */
    public function shouldEmptyCellStayEmptyProvider()
    {
        return [
            'empty cell stay empty#1 - not enough live neighbours' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0),
                        new Cell(0, 1),
                        new Cell(0, 2),
                        new Cell(1, 0),
                        new Cell(1, 2),
                        new Cell(2, 0),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedEvolvedCell' => new Cell(self::CELL_POS_X, self::CELL_POS_Y),
            ],
            'empty cell stay empty#2 - not enough live neighbours of same species' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 1, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 2),
                        new Cell(1, 0, self::CELL_SPECIES),
                        new Cell(1, 2, self::CELL_SPECIES),
                        new Cell(2, 0),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedEvolvedCell' => new Cell(self::CELL_POS_X, self::CELL_POS_Y),
            ],
        ];
    }

    /**
     * @dataProvider shouldEmptyCellAriseWithNewSpeciesProvider
     *
     * @param CellNeighbours $expectedCellNeighbours
     * @param array $expectedCellSpecies
     */
    public function testShouldEmptyCellAriseWithNewSpecies(
        CellNeighbours $expectedCellNeighbours,
        array $expectedCellSpecies
    ) {
        $cell = $this->createEmptyTestCell();
        $this->assertNull($cell->getSpecies());

        $actualEvolvedCell = $cell->evolve($expectedCellNeighbours);

        $this->assertTrue(in_array($actualEvolvedCell->getSpecies(), $expectedCellSpecies));
    }

    /**
     * @return array
     */
    public function shouldEmptyCellAriseWithNewSpeciesProvider()
    {
        return [
            'empty cell will arise' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 1, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 2, self::ANOTHER_CELL_SPECIES),
                        new Cell(1, 0),
                        new Cell(1, 2),
                        new Cell(2, 0),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedCellSpecies' => [self::ANOTHER_CELL_SPECIES],
            ],
            'empty cell will arise#2' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 1, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 2, self::ANOTHER_CELL_SPECIES),
                        new Cell(1, 0, self::ANOTHER_CELL_SPECIES_2),
                        new Cell(1, 2, self::ANOTHER_CELL_SPECIES_2),
                        new Cell(2, 0, self::ANOTHER_CELL_SPECIES_2),
                        new Cell(2, 1, self::ANOTHER_CELL_SPECIES_2),
                        new Cell(2, 2),
                    ]
                ),
                'expectedCellSpecies' => [self::ANOTHER_CELL_SPECIES],
            ],
            'empty cell will arise with randomly chosen species' => [
                'expectedCellNeighbours' => new CellNeighbours(
                    [
                        new Cell(0, 0, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 1, self::ANOTHER_CELL_SPECIES),
                        new Cell(0, 2, self::ANOTHER_CELL_SPECIES),
                        new Cell(1, 0, self::ANOTHER_CELL_SPECIES_2),
                        new Cell(1, 2, self::ANOTHER_CELL_SPECIES_2),
                        new Cell(2, 0, self::ANOTHER_CELL_SPECIES_2),
                        new Cell(2, 1),
                        new Cell(2, 2),
                    ]
                ),
                'expectedCellSpecies' => [self::ANOTHER_CELL_SPECIES, self::ANOTHER_CELL_SPECIES_2],
            ],
        ];
    }

    /**
     * @return Cell
     */
    private function createLiveTestCell(): Cell
    {
        return new Cell(self::CELL_POS_X, self::CELL_POS_Y, self::CELL_SPECIES);
    }

    /**
     * @return Cell
     */
    private function createEmptyTestCell(): Cell
    {
        return new Cell(self::CELL_POS_X, self::CELL_POS_Y);
    }

}
