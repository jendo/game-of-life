<?php
namespace GameOfLife\Input;

use GameOfLife\Environment\WorldState;
use GameOfLife\Environment\WorldStateFactory;
use GameOfLife\Input\Mapping\Life;
use GameOfLife\Input\Mapping\Organism;
use GameOfLife\Input\Mapping\Organisms;
use GameOfLife\Input\Mapping\World;
use GameOfLife\Exceptions\InvalidInputException;
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
     * @var WorldStateFactory
     */
    private $worldStateFactory;

    /**
     * @param string $filePath
     * @param Service $xmlService
     */
    public function __construct(string $filePath, Service $xmlService, WorldStateFactory $worldStateFactory)
    {
        $this->xmlService = $xmlService;
        $this->filePath = $filePath;
        $this->worldStateFactory = $worldStateFactory;
    }

    /**
     * @return WorldState
     * @throws InvalidInputException
     */
    public function getInitialWorldState() : WorldState
    {
        $input = $this->loadFile();
        $life = $this->parseXmlDocument($input);
        $this->validaXmlData($life);
        $worldState = $this->worldStateFactory->create($life);

        return $worldState;
    }

    /*
     * @return string
     */
    private function loadFile() : string
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
    private function parseXmlDocument(string $input) : Life
    {
        $life = new Life();

        $this->mapXmlElements();

        try {
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
}
