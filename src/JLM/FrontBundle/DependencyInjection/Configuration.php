<?php

namespace JLM\FrontBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

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
        $rootNode = $treeBuilder->root('jlm_front');

        $this->addServiceSection($rootNode);
        
        return $treeBuilder;
    }
    
    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('mailer')->defaultValue('jlm_front.mailer.default')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
