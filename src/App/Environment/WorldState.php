<?php
namespace GameOfLife\Environment;


class WorldState
{
    /**
     * @var Cell[][]
     */
    private $cells;

    /**
     * @var int
     */
    private $iterations;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $species;

    /**
     * @var Cell[]
     */
    private $cellsList;


    /**
     * @param int $iterations
     * @param int $size
     * @param int $species
     * @param Cell[][] $cells
     */
    public function __construct(int $iterations, int $size, int $species, array $cells)
    {
        $this->cells = $cells;
        $this->iterations = $iterations;
        $this->size = $size;
        $this->species = $species;
    }

    /**
     * @return int
     */
    public function getIterations(): int
    {
        return $this->iterations;
    }

    /**
     * @return Cell[][]
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    /**
     * @return Cell[]
     */
    public function getCellsList(): array
    {
        if (isset($this->cellsList) === false) {
            for ($x = 0; $x < $this->getSize(); $x++) {
                for ($y = 0; $y < $this->getSize(); $y++) {
                    $this->cellsList[] = $this->cells[$x][$y];
                }
            }
        }

        return $this->cellsList;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * @param Cell[][] $newGeneration
     * @return WorldState
     */
    public function getNewStateWithNewGeneration(array $newGeneration): WorldState
    {
        return new self($this->iterations, $this->size, $this->species, $newGeneration);
    }

}
