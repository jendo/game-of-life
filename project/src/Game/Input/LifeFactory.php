<?php

declare(strict_types=1);

namespace App\Game\Input;

use InvalidArgumentException;

class LifeFactory
{
    /**
     * @param array{
     *     world: array{
     *          cells:string,
     *          iterations:string
     *     },
     *     organisms: array{
     *          organism:array{
     *              x_pos:string,
     *              y_pos:string
     *          }
     *     }
     * } $data
     * @return Life
     */
    public function create(array $data): Life
    {
        $world = new World(
            (int) $data[Life::FIELD_WORLD][World::FIELD_CELLS],
            (int) $data[Life::FIELD_WORLD][World::FIELD_ITERATIONS]
        );

        $organisms = [];
        foreach ($data[Life::FIELD_ORGANISMS][Life::FIELD_ORGANISM] as $organism) {
            if (is_array($organism) === false) {
                throw new InvalidArgumentException('Organism data must be an array.');
            }

            $organisms[] = new Organism(
                (int) $organism[Organism::FIELD_POSITION_X],
                (int) $organism[Organism::FIELD_POSITION_Y]
            );
        }

        return new Life($world, $organisms);
    }
}
