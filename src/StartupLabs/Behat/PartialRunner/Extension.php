<?php

namespace StartupLabs\Behat\PartialRunner;


use Behat\Behat\Extension\ExtensionInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class Extension implements ExtensionInterface
{
    public function load(array $config, ContainerBuilder $container)
    {
        $container->setParameter(
            'behat.console.command.class',
            '\StartupLabs\Behat\PartialRunner\Console\Command\PartialRunnerCommand'
        );

        $container
            ->register(
                'behat.partial_runner.console.processor.partial_runner',
                '\StartupLabs\Behat\PartialRunner\Console\Processor\PartialRunnerProcessor'
            )
            ->addArgument(new Reference('service_container'))
            ->addTag('behat.console.processor');
    }

    public function getConfig(ArrayNodeDefinition $builder)
    {
    }

    public function getCompilerPasses()
    {
        return array();
    }
}