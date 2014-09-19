<?php


namespace M00t\Behat\PartialRunner\Controller;


use Behat\Gherkin\Gherkin;
use Behat\Testwork\Cli\Controller;
use M00t\Behat\PartialRunner\Filter\PartialRunnerFilter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PartialRunnerController implements Controller
{
    private $gherkin;

    public function __construct(Gherkin $gherkin)
    {
        $this->gherkin = $gherkin;
    }

    public function configure(Command $command)
    {
        $command
            ->addOption(
                '--count-workers',
                null,
                InputOption::VALUE_REQUIRED,
                "Specify the count of workers",
                1
            )
            ->addOption(
                '--worker-number',
                null,
                InputOption::VALUE_REQUIRED,
                "Number of current worker",
                0
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->gherkin->addFilter(new PartialRunnerFilter((int) $input->getOption('count-workers'), (int) $input->getOption('worker-number')));
    }
}