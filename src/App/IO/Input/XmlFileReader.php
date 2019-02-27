<?php
namespace GameOfLife\IO\Input;

use GameOfLife\Environment\Cell;
use GameOfLife\Environment\WorldState;
use GameOfLife\Exceptions\InvalidInputException;
use GameOfLife\IO\Mapping\Life;
use GameOfLife\IO\Mapping\Organism;
use GameOfLife\IO\Mapping\Organisms;
use GameOfLife\IO\Mapping\World;
use Sabre\Xml\ParseException;
use Sabre\Xml\Service;

class XmlFileReader
{
    /**
     * @var string path of xml file to read from
     */
    private $filePath;

    /**
     * @var Service
     */
    private $xmlService;

    /**
     * @param string $filePath
     * @param Service $xmlService
     */
    public function __construct(string $filePath, Service $xmlService)
    {
        $this->xmlService = $xmlService;
        $this->filePath = $filePath;
    }

    /**
     * @return WorldState
     * @throws InvalidInputException
     */
    public function createInitialWorldState(): WorldState
    {
        $input = $this->loadFile();
        $life = $this->parseXmlDocument($input);
        $this->validaXmlData($life);
        $worldState = $this->createWordStateFromXmlObject($life);

        return $worldState;
    }

    /**
     * @return string
     * @throws InvalidInputException
     */
    private function loadFile(): string
    {
        if (!file_exists($this->filePath)) {
            throw new InvalidInputException(sprintf("The file '%s' does not exist.", $this->filePath));
        }

        $content = file_get_contents($this->filePath);

        if (!$content) {
            throw new InvalidInputException(sprintf("Can not read Xml file '%s'.", $this->filePath));
        }

        return $content;
    }

    /*
     * @return void
     */
    private function mapXmlElements()
    {
        $this->xmlService->mapValueObject('{}life', Life::class);
        $this->xmlService->mapValueObject('{}world', World::class);
        $this->xmlService->mapValueObject('{}organism', Organism::class);
        $this->xmlService->mapValueObject('{}organisms', Organisms::class);
    }

    /**
     * @param string $input
     * @return Life
     * @throws InvalidInputException
     */
    private function parseXmlDocument(string $input): Life
    {
        $this->mapXmlElements();

        try {
            /** @var Life $life */
            $life = $this->xmlService->parse($input);
        } catch (ParseException $e) {
            throw new InvalidInputException(sprintf("Can not parse xml content from file '%s'.", $this->filePath));
        }

        return $life;
    }


    /**
     * @param Life $life
     * @throws InvalidInputException
     */
    private function validaXmlData(Life $life)
    {
        if (!isset($life->world)) {
            throw new InvalidInputException("Missing element 'world'");
        }

        if (!isset($life->world->cells)) {
            throw new InvalidInputException("Missing element 'cells'");
        }

        if ($life->world->cells < 0) {
            throw new InvalidInputException("Value of element 'cells' must be positive number");
        }

        if (!isset($life->world->species)) {
            throw new InvalidInputException("Missing element 'species'");
        }

        if ($life->world->species < 0) {
            throw new InvalidInputException("Value of element 'species' must be positive number");
        }

        if (!isset($life->world->iterations)) {
            throw new InvalidInputException("Missing element 'iterations'");
        }

        if ($life->world->iterations < 0) {
            throw new InvalidInputException("Value of element 'iterations' must be positive number");
        }

        if (!isset($life->organisms)) {
            throw new InvalidInputException("Missing element 'organisms'");
        }

        if (!isset($life->organisms->organism)) {
            throw new InvalidInputException("Missing element 'organism'");
        }

        foreach ($life->organisms->organism as $organism) {

            if (!isset($organism->x_pos)) {
                throw new InvalidInputException("Missing element 'x_pos' in some of parent element 'organism'");
            }

            if (!isset($organism->y_pos)) {
                throw new InvalidInputException("Missing element 'y_pos' in some of parent element 'organism'");
            }

            if (!isset($organism->species)) {
                throw new InvalidInputException("Missing element 'species' in some of parent element 'organism'");
            }
        }
    }

    /**
     * @param Life $life
     * @return WorldState
     */
    private function createWordStateFromXmlObject(Life $life): WorldState
    {

        $livingCellsSpecies = [];
        foreach ($life->organisms->organism as $organism) {
            $livingCellsSpecies[$organism->x_pos][$organism->y_pos] = $organism->species;
        }

        $cells = [];
        $livingCells = [];
        for ($x = 0; $x < $life->world->cells; $x++) {
            for ($y = 0; $y < $life->world->cells; $y++) {
                $species = isset($livingCellsSpecies[$x][$y]) ? $livingCellsSpecies[$x][$y] : null;
                $cell = new Cell($x, $y, $species);

                $cells[$x][$y] = $cell;
                if ($cell->isAlive()) {
                    $livingCells[] = $cell;
                }
            }
        }

        return new WorldState(
            $life->world->iterations,
            $life->world->cells,
            $life->world->species,
            $cells
        );
    }
}
