<?php
namespace GameOfLife\IO\Output;

use Sabre\Xml\Service;

class XmlFileWriterFactory
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
     * @return XmlFileWriter
     */
    public function create(string $xmlFilePath): XmlFileWriter
    {
        return new XmlFileWriter($xmlFilePath, $this->xmlService);
    }
}
