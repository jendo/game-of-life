<?php
namespace GameOfLife\Output;

use Sabre\Xml\Service;

class XmlFileWriter
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
}
