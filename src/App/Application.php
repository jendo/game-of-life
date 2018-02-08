<?php
namespace GameOfLife;

use GameOfLife\Command\RunCommand;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application
{
    /**
     * @var Application
     */
    private $symfonyConsoleApplication;

    /**
     * @var RunCommand
     */
    private $command;

    /**
     * @param ConsoleApplication $consoleApplication
     * @param RunCommand $command
     */
    public function __construct(ConsoleApplication $consoleApplication, RunCommand $command)
    {
        $this->symfonyConsoleApplication = $consoleApplication;
        $this->command = $command;
    }

    private function initialize()
    {
        $this->symfonyConsoleApplication->add($this->command);
    }

    public function run()
    {
        $this->initialize();
        $this->symfonyConsoleApplication->run();
    }

}
