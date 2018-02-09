<?php
namespace GameOfLife\Tests\Environment;

use GameOfLife\Environment\Cell;
use GameOfLife\Environment\CellNeighbours;
use PHPUnit\Framework\TestCase;

class CellNeighboursTest extends TestCase
{

    const AVAILABLE_SPECIES_1 = 'X';
    const AVAILABLE_SPECIES_2 = 'Y';
    const AVAILABLE_SPECIES_3 = 'Z';


    /**
     * @dataProvider neighboursProvider
     * @param array $neighbours
     * @param array $expectedAvailableSpecies
     */
    public function testShouldReturnAvailableNeighboursSpecies(array $neighbours, array $expectedAvailableSpecies)
    {
        $ceilNeighbours = new CellNeighbours($neighbours);
        $actualAvailableSpecies = $ceilNeighbours->getAvailableSpecies();

        $this->assertSame($expectedAvailableSpecies, $actualAvailableSpecies);
    }

    /**
     * @return array
     */
    public function neighboursProvider()
    {
        return [
            [
                'neighbours' => [
                    new Cell(0, 0, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 1, self::AVAILABLE_SPECIES_2),
                    new Cell(0, 2, self::AVAILABLE_SPECIES_3),
                ],
                'expectedAvailableSpecies' => [
                    self::AVAILABLE_SPECIES_1,
                    self::AVAILABLE_SPECIES_2,
                    self::AVAILABLE_SPECIES_3,
                ],
            ],
            [
                'neighbours' => [
                    new Cell(0, 0, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 1, self::AVAILABLE_SPECIES_2),
                    new Cell(0, 2, self::AVAILABLE_SPECIES_2),
                ],
                'expectedAvailableSpecies' => [
                    self::AVAILABLE_SPECIES_1,
                    self::AVAILABLE_SPECIES_2,
                ],
            ],
        ];
    }

}
