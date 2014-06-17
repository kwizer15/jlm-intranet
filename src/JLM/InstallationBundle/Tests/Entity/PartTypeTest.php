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
class PartTypeTest extends \PHPUnit_Framework_TestCase
{
    private $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new \JLM\InstallationBundle\Entity\PartType('foo', array(
            $this->getMock('JLM\InstallationBundle\Model\PartStateInterface'),
            $this->getMock('JLM\InstallationBundle\Model\PartStateInterface'),
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\InstallationBundle\Model\PartTypeInterface', $this->entity);
    }
    
    public function testGetName()
    {
        $this->assertSame('foo',$this->entity->getName());
    }
    
    public function testGetStates()
    {
        $this->assertCount(2, $this->entity->getStates());
    }
    
    public function test__toString()
    {
        $this->assertSame('foo', (string)$this->entity);
    }
}