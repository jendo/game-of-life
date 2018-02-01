<?php
namespace GameOfLife;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SingleCommand extends Command
{
    const COMMAND_NAME = 'game:run';
    const INPUT_COMMAND_ARGUMENT = 'i';

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->addArgument(self::INPUT_COMMAND_ARGUMENT, InputArgument::REQUIRED, 'Input XML file');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {

    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputXmlFilePath = $input->getArgument(self::INPUT_COMMAND_ARGUMENT);

        $a = new SymfonyStyle($input, $output);
        $a->error('Invalid xml file');
    }

}
