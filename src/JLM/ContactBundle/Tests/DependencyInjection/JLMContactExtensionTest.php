<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Tests\DependencyInjection;

use JLM\ContactBundle\DependencyInjection\JLMContactExtension;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class JLMContactExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->ext = new JLMContactExtension();
    }
    
    public function assertPreConditions()
    {
        $this->assertInstanceOf('Symfony\Component\HttpKernel\DependencyInjection\Extension', $this->ext);
    }
    
    public function testLoad()
    {
        $this->ext->load(array(), $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder'));
    }
}