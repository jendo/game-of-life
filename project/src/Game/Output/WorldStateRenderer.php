<?php

declare(strict_types=1);

namespace App\Game\Output;

use App\Game\Environment\Cell;
use App\Game\Environment\CellNotFoundAtPositionException;
use App\Game\Environment\WorldState;

class WorldStateRenderer
{
    private const DEAD_CELL = '-';
    private const LIVE_CELL = 'X';

    /**
     * @param WorldState $worldState
     * @return array<int, array<int,string>>
     */
    public function render(WorldState $worldState): array
    {
        $cellArray = [];
        for ($x = 0; $x < $worldState->getWorldSize(); $x++) {
            for ($y = 0; $y < $worldState->getWorldSize(); $y++) {
                try {
                    $cell = $worldState->getCellByPosition($x, $y);
                    $cellArray[$y][$x] = $this->renderCellState($cell);
                } catch (CellNotFoundAtPositionException $e) {
                    $cellArray[$y][$x] = self::DEAD_CELL;
                }
            }
        }

        return array_reverse($cellArray);
    }

    private function renderCellState(Cell $cell): string
    {
        return $cell->isAlive() ? self::LIVE_CELL : self::DEAD_CELL;
    }
}
