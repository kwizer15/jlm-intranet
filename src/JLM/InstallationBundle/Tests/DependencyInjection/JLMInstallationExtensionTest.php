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

use JLM\InstallationBundle\DependencyInjection\JLMInstallationExtension;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class JLMInstallationExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->ext = new JLMInstallationExtension();
    }

    public function assertPreConditions()
    {
        $this->assertInstanceOf('Symfony\Component\HttpKernel\DependencyInjection\Extension', $this->ext);
    }

    public function testLoad()
    {
        $this->ext->load([], $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder'));
    }
}
