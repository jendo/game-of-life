<?php
namespace GameOfLife\Environment;

use GameOfLife\Input\Mapping\Life;

class WorldStateFactory
{
    /**
     * @param Life $life
     * @return WorldState
     */
    public function create(Life $life) : WorldState
    {
        $cells = $this->createCellMap($life);

        return new WorldState($cells, $life->world->cells);
    }

    /**
     * @param Life $life
     * @return array
     */
    private function createCellMap(Life $life) : array
    {
        $livingCells = [];
        $cells = [];

        foreach ($life->organisms->organism as $organism) {
            $livingCells[$organism->x_pos][$organism->y_pos] = $organism->species;
        }

        for ($x = 0; $x < $life->world->cells; $x++) {
            for ($y = 0; $y < $life->world->cells; $y++) {
                $species = isset($livingCells[$x][$y]) ? $livingCells[$x][$y] : null;
                $cells[] = new Cell($x, $y, $species);
            }
        }


        return $cells;
    }
}
