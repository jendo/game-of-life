<?php
namespace GameOfLife\Input;

use GameOfLife\Environment\WorldStateFactory;
use Sabre\Xml\Service;

class XmlFileReaderFactory
{
    /**
     * @var Service
     */
    private $xmlService;

    /**
     * @var WorldStateFactory
     */
    private $worldStateFactory;

    /**
     * @param Service $xmlService
     */
    public function __construct(Service $xmlService, WorldStateFactory $worldStateFactory)
    {
        $this->xmlService = $xmlService;
        $this->worldStateFactory = $worldStateFactory;
    }

    public function create(string $xmlFilePath) : XmlFileReader
    {
        return new XmlFileReader($xmlFilePath, $this->xmlService, $this->worldStateFactory);
    }
}
