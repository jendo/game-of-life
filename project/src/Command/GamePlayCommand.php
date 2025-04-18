<?php

declare(strict_types=1);

namespace App\Command;

use App\File\FileNotExistException;
use App\File\FileNotReadableException;
use App\File\Loader;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GamePlayCommand extends Command
{
    private const INPUT_ARG = 'i';
    private const OUTPUT_ARG = 'o';

    private Loader $fileLoader;

    public function __construct(Loader $fileLoader)
    {
        parent::__construct();
        $this->fileLoader = $fileLoader;
    }

    protected function configure(): void
    {
        $this
            ->setName('game:play')
            ->setDescription('Play Game of Life')
            ->addArgument(self::INPUT_ARG, InputArgument::OPTIONAL, 'Input XML file', 'samples/input.xml')
            ->addArgument(self::OUTPUT_ARG, InputArgument::OPTIONAL, 'Output XML file', 'samples/output.xml');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $inputXml = $this->getInputXml($input);
        } catch (InvalidArgumentException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            return -1;
        }

        try {
            $content = $this->fileLoader->load($inputXml);
        } catch (FileNotExistException|FileNotReadableException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            return -1;
        }

        return 0;
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    private function getInputXml(InputInterface $input): string
    {
        $inputXml = $input->getArgument(self::INPUT_ARG);

        if (is_string($inputXml) === false) {
            throw new InvalidArgumentException(
                sprintf('Invalid argument provided for input XML. Expected a string, but received %s.', gettype($inputXml))
            );
        }

        if (empty(trim($inputXml))) {
            throw new InvalidArgumentException('Input XML argument cannot be an empty string.');
        }

        return $inputXml;
    }
}
