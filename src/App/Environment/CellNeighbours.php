<?php
namespace GameOfLife\Environment;

class CellNeighbours
{
    const NUMBER_OF_NEIGHBOURS_OF_SAME_SPECIES_NEEDED_FOR_RISE = 3;

    /**
     * @var Cell[]
     */
    private $neighbours;

    /**
     * @var array
     */
    private $availableSpeciesCounts;

    /**
     * @param Cell[] $neighbours
     */
    public function __construct(array $neighbours)
    {
        $this->neighbours = $neighbours;
        $this->availableSpeciesCounts = $this->getAvailableSpeciesCounts($neighbours);

    }

    /**
     * @return Cell[]
     */
    public function getNeighbours()
    {
        return $this->neighbours;
    }

    /**
     * @param string $species
     * @return int
     */
    public function getSpeciesCount(?string $species): int
    {
        return isset($this->availableSpeciesCounts[$species]) ? $this->availableSpeciesCounts[$species] : 0;
    }

    /**
     * @return array
     */
    public function getAvailableSpecies(): array
    {
        return array_keys($this->availableSpeciesCounts);
    }

    /**
     * @return array
     */
    public function getAvailableSpeciesForRise(): array
    {
        return array_values(
            array_filter($this->getAvailableSpecies(), function ($species) {
                if ($this->getSpeciesCount($species) === self::NUMBER_OF_NEIGHBOURS_OF_SAME_SPECIES_NEEDED_FOR_RISE) {
                    return true;
                }

                return false;
            })
        );
    }

    /**
     * @param Cell[] $neighbours
     * @return array
     */
    private function getAvailableSpeciesCounts(array $neighbours): array
    {
        $counts = [];
        foreach ($neighbours as $cell) {
            $species = $cell->getSpecies();
            if ($species !== null) {
                $counts[$species] = $counts[$species] ?? 0;
                $counts[$species]++;
            }
        }

        return $counts;
    }
}
