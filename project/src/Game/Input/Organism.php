<?php

declare(strict_types=1);

namespace App\Game\Input;

class Organism
{
    public const FIELD_POSITION_X = 'x_pos';
    public const FIELD_POSITION_Y = 'y_pos';

    private int $x_pos;

    private int $y_pos;

    public function __construct(int $x_pos, int $y_pos)
    {
        $this->x_pos = $x_pos;
        $this->y_pos = $y_pos;
    }

    public function getXPosition(): int
    {
        return $this->x_pos;
    }

    public function getYPosition(): int
    {
        return $this->y_pos;
    }
}
