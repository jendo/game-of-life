<?php
namespace GameOfLife\Environment;

class Cell
{
    /**
     * @var int
     */
    private $posX;

    /**
     * @var int
     */
    private $posY;

    /**
     * @var string|null
     */
    private $species;

    public function __construct(int $posX, int $posY, ?string $species = null)
    {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->species = $species;
    }

    /**
     * @return bool
     */
    public function isAlive(): bool
    {
        return ($this->species !== null);
    }

    /**
     * @return int
     */
    public function getPosX(): int
    {
        return $this->posX;
    }

    /**
     * @return int
     */
    public function getPosY(): int
    {
        return $this->posY;
    }

    /**
     * @return string|null
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * @param CellNeighbours $neighbours
     * @return Cell
     */
    public function evolve(CellNeighbours $neighbours): Cell
    {
        $state = $this->getNewState($neighbours);

        if ($state->isTerminated() || $state->stayEmpty()) {
            return new self($this->getPosX(), $this->getPosY());
        }

        if ($state->stayAlive()) {
            return $this;
        }

        if ($state->isArise()) {
            return new self($this->getPosX(), $this->getPosY(), $state->getNewSpecies());
        }

        return $this;
    }

    /**
     * @param CellNeighbours $neighbours
     * @return CellState
     */
    private function getNewState(CellNeighbours $neighbours): CellState
    {
        if ($this->isAlive()) {
            $countNeighboursOfSameSpecies = $neighbours->getSpeciesCount($this->getSpecies());
            $state = $this->getLiveCellNewState($countNeighboursOfSameSpecies);
        } else {
            $availableSpeciesForRise = $neighbours->getAvailableSpeciesForRise();
            $state = $this->getEmptyCellNewState($availableSpeciesForRise);
        }

        return $state;
    }

    /**
     * @param int $countNeighboursOfSameSpecies
     * @return CellState
     */
    private function getLiveCellNewState(int $countNeighboursOfSameSpecies): CellState
    {
        if ($countNeighboursOfSameSpecies === 2 || $countNeighboursOfSameSpecies === 3) {
            return new CellState(CellState::STAY_ALIVE);
        }

        return new CellState(CellState::TERMINATED);
    }

    /**
     * @param array $availableSpeciesForRise
     * @return CellState
     */
    private function getEmptyCellNewState(array $availableSpeciesForRise): CellState
    {
        if ($availableSpeciesForRise !== []) {
            return new CellState(CellState::ARISE, $this->getSpeciesForNewOrganismInCell($availableSpeciesForRise));
        }

        return new CellState(CellState::STAY_EMPTY);
    }

    private function getSpeciesForNewOrganismInCell(array $availableSpeciesForRise): ?string
    {
        return $availableSpeciesForRise[array_rand($availableSpeciesForRise)];
    }
}
