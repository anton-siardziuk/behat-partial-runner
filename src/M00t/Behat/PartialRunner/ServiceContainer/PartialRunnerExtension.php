<?php

namespace M00t\Behat\PartialRunner\ServiceContainer;


use Behat\Behat\Gherkin\ServiceContainer\GherkinExtension;
use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\EventDispatcher\ServiceContainer\EventDispatcherExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class PartialRunnerExtension implements ExtensionInterface
{
    public function load(ContainerBuilder $container, array $config)
    {
        $definition = new Definition('M00t\Behat\PartialRunner\Controller\PartialRunnerController', array(
            new Reference(GherkinExtension::MANAGER_ID)
        ));
        $definition->addTag(CliExtension::CONTROLLER_TAG, array('priority' => 999));
        $container->setDefinition(CliExtension::CONTROLLER_TAG . '.partial_runner', $definition);
    }

    public function configure(ArrayNodeDefinition $builder)
    {

    }

    public function getConfigKey()
    {
        return 'partial_runner';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    public function process(ContainerBuilder $container)
    {
    }
}
