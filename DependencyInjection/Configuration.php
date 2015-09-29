<?php

namespace Sopinet\ChatBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sopinet_chat');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $defaultTypeMessage = array();

        $defaultTypeMessage['text'] = array();
        $defaultTypeMessage['text']['enabled'] = true;
        $defaultTypeMessage['text']['interfaceEnabled'] = true;
        $defaultTypeMessage['text']['class'] = "Sopinet\ChatBundle\Entity\MessageText";

        $defaultTypeMessage['image'] = array();
        $defaultTypeMessage['image']['enabled'] = true;
        $defaultTypeMessage['image']['interfaceEnabled'] = true;
        $defaultTypeMessage['image']['class'] = "Sopinet\ChatBundle\Entity\MessageImage";

        $rootNode
                ->children()
                    ->booleanNode('anyType')->defaultFalse()->end()
                    ->booleanNode('enabledAndroid')->defaultTrue()->end()
                    ->booleanNode('enabledIOS')->defaultTrue()->end()
                    ->arrayNode('basic_type_message')
                        ->defaultValue($defaultTypeMessage)
                        ->prototype('array')
                            ->children()
                                ->booleanNode('enabled')->defaultTrue()->end()
                                ->booleanNode('interfaceEnabled')->defaultTrue()->end()
                                ->scalarNode('class')->end()
                                ->scalarNode('iosNotificationFields')->defaultValue('fromUsername')->end() // TODO: No está terminado
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('extra_type_message')
                        ->prototype('array')
                            ->children()
                                ->booleanNode('enabled')->defaultTrue()->end()
                                ->booleanNode('interfaceEnabled')->defaultTrue()->end()
                                ->scalarNode('class')->end()
                                ->scalarNode('iosNotificationFields')->defaultValue('fromUsername')->end() // TODO: No está terminado
                            ->end()
                        ->end()
                    ->end();

        return $treeBuilder;
    }
}