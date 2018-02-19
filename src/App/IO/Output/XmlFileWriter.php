<?php
namespace GameOfLife\IO\Output;

use GameOfLife\Environment\WorldState;
use GameOfLife\Exceptions\InvalidOutputException;
use GameOfLife\IO\Mapping\Life;
use GameOfLife\IO\Mapping\Organism;
use GameOfLife\IO\Mapping\Organisms;
use InvalidArgumentException;
use Sabre\Xml\Service;
use GameOfLife\IO\Mapping\World as MappingWorld;

class XmlFileWriter
{
    /**
     * @var Service
     */
    private $xmlService;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @param string $filePath
     * @param Service $xmlService
     */
    public function __construct(string $filePath, Service $xmlService)
    {
        $this->xmlService = $xmlService;
        $this->filePath = $filePath;
        $this->xmlService->namespaceMap = ['' => ''];
    }

    /**
     * @param WorldState $worldState
     * @return void
     * @throws InvalidOutputException
     */
    public function saveWorldState(WorldState $worldState)
    {
        $object = $this->createValueObject($worldState);

        try {
            $content = $this->xmlService->writeValueObject($object);
        } catch (InvalidArgumentException $e) {
            throw new InvalidOutputException($e->getMessage());
        }

        $result = file_put_contents($this->filePath, $content);

        if ($result === false) {
            throw new InvalidOutputException(sprintf("Can not write the output into xml file: %s", $this->filePath));
        }
    }

    /**
     * @param WorldState $worldState
     * @return Life
     */
    private function createValueObject(WorldState $worldState): Life
    {
        $life = new Life();

        $world = new MappingWorld();
        $world->iterations = $worldState->getIterations();
        $world->cells = $worldState->getSize();
        $world->species = $worldState->getSpecies();
        $life->world = $world;

        $organisms = new Organisms();

        foreach ($worldState->getCellsList() as $cell) {
            $organism = new Organism();

            if ($cell->getSpecies() !== null) {
                $organism->x_pos = $cell->getPosX();
                $organism->y_pos = $cell->getPosY();
                $organism->species = $cell->getSpecies();
                $organisms->organism[] = $organism;
            }
        }

        $life->organisms = $organisms;

        return $life;
    }
}
