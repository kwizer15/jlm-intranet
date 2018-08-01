<?php

/*
 * This file is part of the JLMInstallationBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\InstallationBundle\Tests\DependencyInjection;

use JLM\InstallationBundle\DependencyInjection\Configuration;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->conf = new Configuration();
    }
    
    public function assertPreCondition()
    {
        $this->assertInstanceOf('Symfony\Component\Config\Definition\ConfigurationInterface', $this->conf);
    }
    
    public function testGetConfigTreeBuilder()
    {
        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $this->conf->getConfigTreeBuilder());
    }
}