<?php
namespace GameOfLife\Environment;


class WorldState
{
    /**
     * @var Cell[]
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
     * @param int $iterations
     * @param int $size
     * @param Cell[] $cells
     */
    public function __construct(int $iterations, int $size, array $cells)
    {
        $this->cells = $cells;
        $this->iterations = $iterations;
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getIterations()
    {
        return $this->iterations;
    }

    /**
     * @return Cell[]
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }


}
