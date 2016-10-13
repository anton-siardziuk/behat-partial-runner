<?php


namespace Behat\PartialRunner\Controller;


use Behat\Gherkin\Gherkin;
use Behat\Testwork\Cli\Controller;
use InvalidArgumentException;
use Behat\PartialRunner\Filter\PartialRunnerFilter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PartialRunnerController implements Controller
{
    private $gherkin;

    /**
     * {@inheritdoc}
     */
    public function __construct(Gherkin $gherkin)
    {
        $this->gherkin = $gherkin;
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $total = $input->getOption('count-workers');
        $worker = $input->getOption('worker-number');

        if ($total < 0 || $worker < 0) {
            throw new InvalidArgumentException("--worker-number ($worker) and --count-workers ($total) must be greater than 0. ");
        }

        if ($worker >= $total) {
            throw new InvalidArgumentException("--worker-number ($worker) must be less than --count-workers ($total). ");
        }

        $this->gherkin->addFilter(new PartialRunnerFilter($total, $worker));
    }
}