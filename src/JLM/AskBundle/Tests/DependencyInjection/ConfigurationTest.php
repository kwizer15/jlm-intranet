<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\AskBundle\Tests\DependencyInjection;

use JLM\AskBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ConfigurationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Configuration
     */
    private $conf;

    public function setUp()
    {
        $this->conf = new Configuration();
    }
    
    public function assertPreCondition()
    {
        $this->assertInstanceOf(ConfigurationInterface::class, $this->conf);
    }
    
    public function testGetConfigTreeBuilder()
    {
        $this->assertInstanceOf(TreeBuilder::class, $this->conf->getConfigTreeBuilder());
    }
}