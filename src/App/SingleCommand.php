<?php
namespace GameOfLife;

use GameOfLife\Exceptions\InvalidInputException;
use GameOfLife\Input\XmlFileReaderFactory;
use GameOfLife\Output\OutputStyleFactory;
use Sabre\Xml\ParseException;
use Sabre\Xml\Service;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SingleCommand extends Command
{
    const COMMAND_NAME = 'game:run';
    const INPUT_COMMAND_ARGUMENT = 'i';
    
    /**
     * @var OutputStyleFactory
     */
    private $outputStyleFactory;

    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var XmlFileReaderFactory
     */
    private $xmlFileReaderFactoryory;

    /**
     * @param OutputStyleFactory $outputStyleFactory
     * @param XmlFileReaderFactory $xmlFileReaderFactory
     */
    public function __construct(OutputStyleFactory $outputStyleFactory, XmlFileReaderFactory $xmlFileReaderFactory)
    {
        parent::__construct();
        $this->outputStyleFactory = $outputStyleFactory;
        $this->xmlFileReaderFactoryory = $xmlFileReaderFactory;
    }


    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->addArgument(self::INPUT_COMMAND_ARGUMENT, InputArgument::OPTIONAL, 'Input XML file', 'input.xml');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->symfonyStyle = $this->outputStyleFactory->create($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputXmlFilePath = $input->getArgument(self::INPUT_COMMAND_ARGUMENT);
        $xmlFileReader = $this->xmlFileReaderFactoryory->create($inputXmlFilePath);

        try {
            $data = $xmlFileReader->getData();
        } catch (InvalidInputException $e) {
            $this->symfonyStyle->error($e->getMessage());
        }
    }

}
