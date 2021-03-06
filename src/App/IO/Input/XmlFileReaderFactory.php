<?php
namespace GameOfLife\IO\Input;

use Sabre\Xml\Service;

class XmlFileReaderFactory
{
    /**
     * @var Service
     */
    private $xmlService;

    /**
     * @param Service $xmlService
     */
    public function __construct(Service $xmlService)
    {
        $this->xmlService = $xmlService;
    }

    /**
     * @param string $xmlFilePath
     * @return XmlFileReader
     */
    public function create(string $xmlFilePath) : XmlFileReader
    {
        return new XmlFileReader($xmlFilePath, $this->xmlService);
    }
}
