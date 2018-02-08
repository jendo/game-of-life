<?php
namespace GameOfLife\Helper;

use GameOfLife\Environment\Cell;
use GameOfLife\Environment\WorldState;

class WorldFormatter
{
    const EMPTY_CELL = '-';

    /**
     * @param WorldState $worldState
     * @return array
     */
    public function getWorldStateAsArray(WorldState $worldState): array
    {
        $cellArray = [];
        $cells = $worldState->getCells();

        for ($x = 0; $x < $worldState->getSize(); $x++) {
            for ($y = 0; $y < $worldState->getSize(); $y++) {
                /** @var Cell $cell */
                $cell = $cells[$x][$y];
                $cellArray[$y][$x] = $this->getCellTablePresentation($cell);
            }
        }

        return array_reverse($cellArray);
    }

    /**
     * @param Cell $cell
     * @return string
     */
    private function getCellTablePresentation(Cell $cell): string
    {
        return $cell->isAlive() ? $cell->getSpecies() : self::EMPTY_CELL;
    }
}
