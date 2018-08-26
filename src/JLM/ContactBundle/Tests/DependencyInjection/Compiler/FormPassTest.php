<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Tests\DependencyInjection\Compiler;

use JLM\ContactBundle\DependencyInjection\Compiler\FormPass;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FormPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        
        $this->container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $this->pass = new FormPass();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface', $this->pass);
    }
    
    public function testProcess()
    {
        $this->container->expects($this->once())->method('getParameter');
        $this->container->expects($this->once())->method('setParameter');
        $this->pass->process($this->container);
    }
}
