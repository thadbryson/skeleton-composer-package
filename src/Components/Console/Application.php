<?php

namespace AnonPain\Components\Console;

AnonPain\Components\Console\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Application as SymfonyConsoleApplication;

class Application extends SymfonyConsoleApplication
{
    protected $lastOutput = null;



    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array  $parameters
     * @return int
     */
    public function call($commandName, array $parameters = [])
    {
        $parameters['command'] = $commandName;

        $this->lastOutput = new BufferedOutput();

        return $this->find($commandName)->run(new ArrayInput($parameters), $this->lastOutput);
    }

    /**
     * Get the output for the last run command.
     *
     * @return string
     */
    public function output()
    {
        return $this->lastOutput ? $this->lastOutput->fetch() : '';
    }

    /**
     * Get the default input definitions for the applications.
     *
     * This is used to add the --env option to every available command.
     *
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption($this->getEnvironmentOption());

        return $definition;
    }

    /**
     * Get the global environment option for the definition.
     *
     * @return \Symfony\Component\Console\Input\InputOption
     */
    protected function getEnvironmentOption()
    {
        return new InputOption('--env', null, InputOption::VALUE_OPTIONAL, 'The environment the command should run in.');
    }
}
