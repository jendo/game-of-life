<?php
namespace GameOfLife\Command;

use GameOfLife\Environment\WorldFactory;
use GameOfLife\Exceptions\InvalidInputException;
use GameOfLife\Exceptions\InvalidOutputException;
use GameOfLife\Helper\WorldFormatter;
use GameOfLife\IO\Input\XmlFileReaderFactory;
use GameOfLife\IO\Output\OutputStyleFactory;
use GameOfLife\IO\Output\XmlFileWriterFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RunCommand extends Command
{
    const CYCLES_PER_SECOND = 3;
    const COMMAND_NAME = 'game:run';
    const INPUT_COMMAND_ARGUMENT = 'i';
    const OUTPUT_COMMAND_ARGUMENT = 'o';

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
    private $xmlFileReaderFactory;

    /**
     * @var WorldFormatter
     */
    private $worldFormatter;

    /**
     * @var WorldFactory
     */
    private $worldFactory;

    /**
     * @var XmlFileWriterFactory
     */
    private $xmlFileWriterFactory;

    /**
     * @param OutputStyleFactory $outputStyleFactory
     * @param XmlFileReaderFactory $xmlFileReaderFactory
     * @param XmlFileWriterFactory $xmlFileWriterFactory
     * @param WorldFormatter $worldFormatter
     * @param WorldFactory $worldFactory
     */
    public function __construct(
        OutputStyleFactory $outputStyleFactory,
        XmlFileReaderFactory $xmlFileReaderFactory,
        XmlFileWriterFactory $xmlFileWriterFactory,
        WorldFormatter $worldFormatter,
        WorldFactory $worldFactory
    ) {
        parent::__construct();
        $this->outputStyleFactory = $outputStyleFactory;
        $this->xmlFileReaderFactory = $xmlFileReaderFactory;
        $this->worldFormatter = $worldFormatter;
        $this->worldFactory = $worldFactory;
        $this->xmlFileWriterFactory = $xmlFileWriterFactory;
    }


    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->addArgument(self::INPUT_COMMAND_ARGUMENT, InputArgument::REQUIRED, 'Input XML file');
        $this->addArgument(self::OUTPUT_COMMAND_ARGUMENT, InputArgument::OPTIONAL, 'Output XML file', 'output.xml');
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
        $inputXmlFilePathToRead = $input->getArgument(self::INPUT_COMMAND_ARGUMENT);
        $xmlFileReader = $this->xmlFileReaderFactory->create($inputXmlFilePathToRead);

        try {
            $worldState = $xmlFileReader->createInitialWorldState();
        } catch (InvalidInputException $e) {
            $this->symfonyStyle->error($e->getMessage());
            exit;
        }

        for ($i = 0; $i < $worldState->getIterations(); $i++) {
            // just printing
            $this->clearOutput($output);
            $data = $this->worldFormatter->getWorldStateAsArray($worldState);
            $this->symfonyStyle->table([], $data);
            $this->sleep();

            $world = $this->worldFactory->create($worldState);
            $worldState = $world->evolve();
        }

        $inputXmlFilePathToWrite = $input->getArgument(self::OUTPUT_COMMAND_ARGUMENT);
        $xmlFileWriter = $this->xmlFileWriterFactory->create($inputXmlFilePathToWrite);

        try {
            $xmlFileWriter->saveWorldState($worldState);
        } catch (InvalidOutputException $e) {
            $this->symfonyStyle->error($e->getMessage());
            exit;
        }
    }

    /**
     * @param OutputInterface $output
     */
    private function clearOutput(OutputInterface $output)
    {
        $output->write(sprintf("\033\143"));
    }

    /**
     * @return void
     */
    private function sleep()
    {
        usleep((int)floor(1000000 / self::CYCLES_PER_SECOND));
    }

}
