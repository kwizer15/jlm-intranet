<?php

/*
 * This file is part of the JLMFeeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Tests\DependencyInjection;

use JLM\FeeBundle\DependencyInjection\JLMFeeExtension;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class JLMFeeExtensionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->ext = new JLMFeeExtension();
    }
    
    public function assertPreConditions()
    {
        $this->assertInstanceOf('Symfony\Component\HttpKernel\DependencyInjection\Extension', $this->ext);
    }
    
    public function testLoad()
    {
        $this->ext->load([], $this->createMock('Symfony\Component\DependencyInjection\ContainerBuilder'));
    }
}
