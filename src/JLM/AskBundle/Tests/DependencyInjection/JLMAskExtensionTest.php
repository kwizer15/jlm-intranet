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

use JLM\AskBundle\DependencyInjection\JLMAskExtension;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class JLMAskExtensionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->ext = new JLMAskExtension();
    }
    
    public function assertPreConditions()
    {
        $this->assertInstanceOf('Symfony\Component\HttpKernel\DependencyInjection\Extension', $this->ext);
    }
    
    public function testLoad()
    {
        $this->ext->load(array(), $this->createMock('Symfony\Component\DependencyInjection\ContainerBuilder'));
    }
}