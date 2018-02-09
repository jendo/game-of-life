<?php
namespace GameOfLife\Environment;

class NeighboursFactory
{
    /**
     * @param Cell $cell
     * @param WorldState $worldState
     * @return CellNeighbours
     */
    public function createNeighbours(Cell $cell, WorldState $worldState): CellNeighbours
    {
        $worldSize = $worldState->getSize();
        $cells = $worldState->getCells();

        $minY = max(0, $cell->getPosY() - 1);
        $maxY = min($worldSize - 1, $cell->getPosY() + 1);
        $minX = max(0, $cell->getPosX() - 1);
        $maxX = min($worldSize - 1, $cell->getPosX() + 1);

        $neighbours = [];
        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                if ($x === $cell->getPosX() && $y === $cell->getPosY()) {
                    continue;
                }
                $neighbours[] = $cells[$x][$y];
            }
        }

        return new CellNeighbours($neighbours);
    }
}
