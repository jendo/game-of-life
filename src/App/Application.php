<?php
namespace GameOfLife;

use Symfony\Component\Console\Application as ConsoleApplication;

class Application
{
    const IS_SINGLE_COMMAND_APPLICATION = true;

    /**
     * @var Application
     */
    private $symfonyConsoleApplication;

    /**
     * @var SingleCommand
     */
    private $command;

    /**
     * ConsoleApplication constructor.
     * @param ConsoleApplication $consoleApplication
     * @param SingleCommand $command
     */
    public function __construct(ConsoleApplication $consoleApplication, SingleCommand $command)
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
