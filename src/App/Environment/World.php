<?php
namespace GameOfLife\Environment;

class World
{
    /**
     * @var WorldState
     */
    private $worldState;

    /**
     * @var NeighboursFactory
     */
    private $neighboursFactory;

    /**
     * @param WorldState $worldState
     * @param NeighboursFactory $neighboursFactory
     */
    public function __construct(WorldState $worldState, NeighboursFactory $neighboursFactory)
    {
        $this->worldState = $worldState;
        $this->neighboursFactory = $neighboursFactory;
    }

    /**
     * @return WorldState
     */
    public function evolve(): WorldState
    {
        $cells = $this->worldState->getCells();
        $wordSize = $this->worldState->getSize();

        $newGeneration = [];
        for ($x = 0; $x < $wordSize; $x++) {
            for ($y = 0; $y < $wordSize; $y++) {
                /** @var Cell $cell */
                $cell = $cells[$x][$y];
                $neighbours = $this->neighboursFactory->createNeighbours($cell, $this->worldState);
                $newGeneration[$x][$y] = $cell->evolve($neighbours);
            }
        }

        return new WorldState($this->worldState->getIterations(), $wordSize, $newGeneration);
    }

}
