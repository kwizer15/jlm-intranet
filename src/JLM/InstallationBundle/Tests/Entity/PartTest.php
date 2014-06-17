<?php

/*
 * This file is part of the installation-bundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\InstallationBundle\Tests\Entity;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PartTest extends \PHPUnit_Framework_TestCase
{
    private $entity;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->partType = $this->getMock('JLM\InstallationBundle\Model\PartTypeInterface');
        $this->installation = $this->getMock('JLM\InstallationBundle\Model\InstallationInterface');
        $this->entity = new \JLM\InstallationBundle\Entity\Part($this->installation, $this->partType, 'foo');
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\InstallationBundle\Model\PartInterface', $this->entity);
        $this->assertSame($this->partType, $this->entity->getType());
        $this->assertSame($this->installation, $this->entity->getInstallation());
        $this->assertSame('foo', $this->entity->getLocation());
    }

    public function testGetType()
    {
        $this->assertSame($this->partType, $this->entity->getType());
    }

    public function testGetInstallation()
    {
        $this->assertSame($this->installation, $this->entity->getInstallation());
    }
    
    public function testGetLocation()
    {
        $this->assertSame('foo', $this->entity->getLocation());
    }
    
    public function testGetName()
    {
        $this->partType->expects($this->once())->method('getName')->will($this->returnValue('bar'));
        $this->assertSame('bar (foo)', $this->entity->getName());
        
    }
}