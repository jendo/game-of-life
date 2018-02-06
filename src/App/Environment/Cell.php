<?php
namespace GameOfLife\Environment;

class Cell
{

    const NO_SPECIES_SIGN = '-';

    /**
     * @var int
     */
    private $posX;

    /**
     * @var int
     */
    private $posY;

    /**
     * @var null
     */
    private $species;

    /**
     * @param int $posX
     * @param int $posY
     * @param null|string $species
     */
    public function __construct(int $posX, int $posY, string $species = null)
    {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->species = $species;
    }

    /**
     * @return bool
     */
    public function isAlive() : bool
    {
        return ($this->species !== null);
    }

    /**
     * @return int
     */
    public function getPosX() : int
    {
        return $this->posX;
    }

    /**
     * @return int
     */
    public function getPosY() : int
    {
        return $this->posY;
    }

    /**
     * @return string
     */
    public function getSpecies() : string
    {
        if ($this->isAlive()) {
            return $this->species;
        }

        return self::NO_SPECIES_SIGN;
    }

}
