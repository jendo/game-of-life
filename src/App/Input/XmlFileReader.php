<?php
namespace GameOfLife\Input;

use GameOfLife\Exceptions\InvalidInputException;
use Sabre\Xml\ParseException;
use Sabre\Xml\Reader;
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
     * @throws InvalidInputException
     */
    public function getData()
    {
        $input = $this->loadFile();
        $data = $this->parseXmlDocument($input);
        $this->validaXmlData($data);

        return $data;
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
        $this->xmlService->elementMap = [
            '{}life' => function (Reader $reader) {
                return \Sabre\Xml\Deserializer\keyValue($reader, '');
            },
            '{}world' => function (Reader $reader) {
                return \Sabre\Xml\Deserializer\keyValue($reader, '');
            },
            '{}organism' => function (Reader $reader) {
                return \Sabre\Xml\Deserializer\keyValue($reader, '');
            },
            '{}organisms' => function (Reader $reader) {
                return \Sabre\Xml\Deserializer\repeatingElements($reader, 'organism');
            },
        ];
    }

    /**
     * @param string $input
     * @return array
     * @throws InvalidInputException
     */
    private function parseXmlDocument(string $input) : array
    {
        $data = [];

        $this->mapXmlElements();

        try {
            $data = $this->xmlService->parse($input);
        } catch (ParseException $e) {
            throw new InvalidInputException(sprintf("Can not parse xml content from file '%s'.", $this->filePath));
        }

        return $data;
    }

    /**
     * @param array $xmlData
     * @return void
     * @throws InvalidInputException
     */
    private function validaXmlData(array $xmlData)
    {
        if (!isset($xmlData['world'])) {
            throw new InvalidInputException("Missing element 'world'");
        }

        if (!isset($xmlData['world']['cells'])) {
            throw new InvalidInputException("Missing element 'cells'");
        }

        if (!isset($xmlData['world']['species'])) {
            throw new InvalidInputException("Missing element 'species'");
        }

        if (!isset($xmlData['world']['iterations'])) {
            throw new InvalidInputException("Missing element 'iterations'");
        }

        if (!isset($xmlData['organisms'])) {
            throw new InvalidInputException("Missing element 'organisms'");
        }

        foreach ($xmlData['organisms'] as $organism) {

            if (!isset($organism['x_pos'])) {
                throw new InvalidInputException("Missing element 'x_pos' in some of parent element 'organism'");
            }

            if (!isset($organism['y_pos'])) {
                throw new InvalidInputException("Missing element 'y_pos' in some of parent element 'organism'");
            }

            if (!isset($organism['species'])) {
                throw new InvalidInputException("Missing element 'species' in some of parent element 'organism'");
            }
        }
    }
}
