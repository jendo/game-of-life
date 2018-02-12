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
     * @dataProvider availableNeighboursSpeciesProvider
     *
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
    public function availableNeighboursSpeciesProvider(): array
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

    /**
     * @dataProvider neighboursSpeciesCountProvider
     *
     * @param array $neighbours
     * @param string $species
     * @param int $expectedSpeciesCount
     */
    public function testShouldReturnNeighboursSpeciesCount(
        array $neighbours,
        string $species,
        int $expectedSpeciesCount
    ) {
        $ceilNeighbours = new CellNeighbours($neighbours);

        $actualSpeciesCount = $ceilNeighbours->getSpeciesCount($species);

        $this->assertSame($expectedSpeciesCount, $actualSpeciesCount);
    }

    /**
     * @return array
     */
    public function neighboursSpeciesCountProvider(): array
    {
        return [
            [
                'neighbours' => [
                    new Cell(0, 0, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 1, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 2, self::AVAILABLE_SPECIES_1),
                ],
                'species' => self::AVAILABLE_SPECIES_1,
                'expectedSpeciesCount' => 3,
            ],
            [
                'neighbours' => [
                    new Cell(0, 0, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 1, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 2, self::AVAILABLE_SPECIES_2),
                ],
                'species' => self::AVAILABLE_SPECIES_2,
                'expectedSpeciesCount' => 1,
            ],
            [
                'neighbours' => [
                    new Cell(0, 0, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 1, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 2, self::AVAILABLE_SPECIES_2),
                ],
                'species' => self::AVAILABLE_SPECIES_3,
                'expectedSpeciesCount' => 0,
            ],
        ];
    }

    /**
     * @dataProvider neighboursSpeciesForRiseProvider
     *
     * @param array $neighbours
     * @param array $expectedSpeciesForRise
     */
    public function testShouldReturnAvailableSpeciesForRise(array $neighbours, array $expectedSpeciesForRise)
    {
        $ceilNeighbours = new CellNeighbours($neighbours);

        $actualSpeciesForRise = $ceilNeighbours->getAvailableSpeciesForRise();

        $this->assertSame($expectedSpeciesForRise, $actualSpeciesForRise);
    }

    /**
     * @return array
     */
    public function neighboursSpeciesForRiseProvider(): array
    {
        return [
            [
                'neighbours' => [
                    new Cell(0, 0, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 1, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 2, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 3, self::AVAILABLE_SPECIES_2),
                    new Cell(0, 4, self::AVAILABLE_SPECIES_2),
                    new Cell(0, 5, self::AVAILABLE_SPECIES_3),
                ],
                'expectedSpeciesForRise' => [self::AVAILABLE_SPECIES_1],
            ],
            [
                'neighbours' => [
                    new Cell(0, 0, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 1, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 2, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 3, self::AVAILABLE_SPECIES_2),
                    new Cell(0, 4, self::AVAILABLE_SPECIES_2),
                    new Cell(0, 5, self::AVAILABLE_SPECIES_2),
                ],
                'expectedSpeciesForRise' => [self::AVAILABLE_SPECIES_1, self::AVAILABLE_SPECIES_2],
            ],
            [
                'neighbours' => [
                    new Cell(0, 0, self::AVAILABLE_SPECIES_1),
                    new Cell(0, 1, self::AVAILABLE_SPECIES_2),
                    new Cell(0, 2, self::AVAILABLE_SPECIES_3),
                ],
                'expectedSpeciesForRise' => [],
            ],
        ];
    }
}
