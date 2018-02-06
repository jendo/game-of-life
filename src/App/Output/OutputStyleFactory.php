<?php
namespace GameOfLife\Output;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class OutputStyleFactory
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return SymfonyStyle
     */
    public function create(InputInterface $input, OutputInterface $output) : SymfonyStyle
    {
        return new SymfonyStyle($input, $output);
    }
}
