<?php
namespace GameOfLife\Environment;


class WorldState
{
    /**
     * @var Cell
     */
    private $cells;

    /**
     * @var int
     */
    private $width;

    /**
     * @param Cell[] $cells
     * @param int $width
     */
    public function __construct(array $cells, int $width)
    {
        $this->cells = $cells;
        $this->width = $width;
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
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->width;
    }


}
