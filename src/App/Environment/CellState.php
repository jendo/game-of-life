<?php
namespace GameOfLife\Environment;

class CellState
{
    const STAY_ALIVE = 1;
    const STAY_EMPTY = 2;
    const TERMINATED = 3;
    const ARISE = 4;

    /**
     * @var int
     */
    private $state;

    /**
     * @var null|string
     */
    private $newSpecies;

    /**
     * @param int $state
     * @param null|string $newSpecies
     */
    public function __construct(int $state, $newSpecies = null)
    {
        $this->state = $state;
        $this->newSpecies = $newSpecies;
    }

    /**
     * @return bool
     */
    public function stayAlive(): bool
    {
        return $this->state === self::STAY_ALIVE;
    }

    /**
     * @return bool
     */
    public function stayEmpty(): bool
    {
        return $this->state === self::STAY_EMPTY;
    }

    /**
     * @return bool
     */
    public function isTerminated(): bool
    {
        return $this->state === self::TERMINATED;
    }

    /**
     * @return bool
     */
    public function isArise(): bool
    {
        return $this->state === self::ARISE;
    }

    /**
     * @return string|null
     */
    public function getNewSpecies()
    {
        return $this->newSpecies;
    }

}
