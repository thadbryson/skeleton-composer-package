<?php

namespace AnonPain\Components\Console;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

use Illuminate\Console\OutputStyle;
use Illuminate\Console\Parser;
use Illuminate\Contracts\Support\Arrayable;

abstract class Command extends SymfonyCommand
{
    /**
     * Signature for the command. Parses into: name, arguments, and options.
     *
     * Example: anonpain:database:create {arg1} {arg2=defaultValue} {--option1}
     *
     * @var string
     */
    protected $signature;

    /**
     * Description of the command.
     *
     * @var string
     */
    protected $description;

    /**
     * Help text of the command.
     *
     * @var string
     */
    protected $help;

    /**
     * The input interface implementation.
     *
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * The output interface implementation.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;



    /**
     * Run your command code here.
     */
    abstract protected function execute(InputInterface $input, OutputInterface $output);

    protected function configure()
    {
        list($name, $arguments, $options) = Parser::parse($this->signature);

        $this
            ->setName($name)
            ->setDescription($this->description)
            ->setHelp($this->help)
        ;

        // Add Arguments and Options: Must put in Definition object.
        // Each $argument and $option is an object.
        foreach ($arguments as $argument) {
            $this->getDefinition()->addArgument($argument);
        }

        foreach ($options as $option) {
            $this->getDefinition()->addOption($option);
        }
    }

    public function addStyle($name, $color)
    {
        $name  = strtolower($name);
        $style = new OutputFormatterStyle($color);

        $this->output->getFormatter()->setStyle($name, $style);

        return $this;
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        // Set the Input & Output for the Command.
        $this->input  = $input;
        $this->output = new OutputStyle($input, $output);

        // Load all the style combinations.
        $this->initStyles();

        // Be sure to call instance Input & Output.
        // They were overridden.
        return parent::run($this->input, $this->output);
    }

    /**
     * Call another console command.
     *
     * @param string  $commandName
     * @param array   $arguments
     * @param boolean $silent, default false
     *
     * @return int
     */
    public function runCommand($commandName, array $arguments = [], $silent = false)
    {
        $command = $this->getApplication()->find($commandName);

        $arguments['command'] = $commandName;

        // If silent use NullOutput.
        $output = ($silent === true) ? new NullOutput() : $this->output;

        return $command->run(new ArrayInput($arguments), $output);
    }

    /**
     * Get the value of a command argument.
     *
     * @param  string  $key
     * @return string|array
     */
    public function argument($key = null)
    {
        if (is_null($key)) {
            return $this->input->getArguments();
        }

        return $this->input->getArgument($key);
    }

    /**
     * Get the value of a command option.
     *
     * @param  string  $key
     * @return string|array
     */
    public function option($key = null)
    {
        if (is_null($key)) {
            return $this->input->getOptions();
        }

        return $this->input->getOption($key);
    }

    /**
     * Confirm a question with the user.
     *
     * @param  string  $question
     * @param  bool    $default
     * @return bool
     */
    public function confirm($question, $default = false)
    {
        return $this->output->confirm($question, $default);
    }

    /**
     * Prompt the user for input.
     *
     * @param  string  $question
     * @param  string  $default
     * @return string
     */
    public function ask($question, $default = null)
    {
        return $this->output->ask($question, $default);
    }

    /**
     * Prompt the user for input with auto completion.
     *
     * @param  string  $question
     * @param  array   $choices
     * @param  string  $default
     * @return string
     */
    public function anticipate($question, array $choices, $default = null)
    {
        return $this->askWithCompletion($question, $choices, $default);
    }

    /**
     * Prompt the user for input with auto completion.
     *
     * @param  string  $question
     * @param  array   $choices
     * @param  string  $default
     * @return string
     */
    public function askAutocomplete($question, array $choices, $default = null)
    {
        $question = new Question($question, $default);
        $question->setAutocompleterValues($choices);

        return $this->output->askQuestion($question);
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * @param  string  $question
     * @param  bool    $fallback
     * @return string
     */
    public function secret($question, $fallback = true)
    {
        $question = new Question($question);
        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }

    /**
     * Give the user a single choice from an array of answers.
     *
     * @param  string  $question
     * @param  array   $choices
     * @param  string  $default
     * @param  mixed   $attempts
     * @param  bool    $multiple
     * @return bool
     */
    public function choice($question, array $choices, $default = null, $attempts = null, $multiple = null)
    {
        $question = new ChoiceQuestion($question, $choices, $default);
        $question->setMaxAttempts($attempts)->setMultiselect($multiple);

        return $this->output->askQuestion($question);
    }

    /**
     * Format input to textual table.
     *
     * @param  array   $headers
     * @param  array|\Illuminate\Contracts\Support\Arrayable  $rows
     * @param  string  $style
     * @return void
     */
    public function table(array $headers, $rows, $style = 'default')
    {
        $table = new Table($this->output);

        if ($rows instanceof Arrayable) {
            $rows = $rows->toArray();
        }

        $table
            ->setHeaders($headers)
            ->setRows($rows)
            ->setStyle($style)
            ->render()
        ;
    }

    public function writeln($string, $style = 'info')
    {
        $style = strtolower($style);

        $this->output->writeln("<{$style}>{$string}</{$style}>");
    }
}
