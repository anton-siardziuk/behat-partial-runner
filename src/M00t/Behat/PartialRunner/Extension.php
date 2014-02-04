<?php

namespace M00t\Behat\PartialRunner;


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
            '\M00t\Behat\PartialRunner\Console\Command\PartialRunnerCommand'
        );

        $container
            ->register(
                'behat.partial_runner.console.processor.partial_runner',
                '\M00t\Behat\PartialRunner\Console\Processor\PartialRunnerProcessor'
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