<?php

namespace StartupLabs\Behat\PartialRunner\Console\Processor;

use Behat\Behat\Console\Processor\Processor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PartialRunnerProcessor extends Processor
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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

    public function process(InputInterface $input, OutputInterface $output)
    {
        $command = $this->container->get('behat.console.command');
        $command->setCountWorkers($input->getOption('count-workers'));
        $command->setWorkerNumber($input->getOption('worker-number'));
    }
}