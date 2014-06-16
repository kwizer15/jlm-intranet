<?php

/*
 * This file is part of the  package.
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
        $this->category = $this->getMock('JLM\InstallationBundle\Model\PartCategoryInterface');
        $this->entity = new \JLM\InstallationBundle\Entity\Part('foo', $this->category, array(
            $this->getMock('JLM\InstallationBundle\Model\PartStateInterface'),
            $this->getMock('JLM\InstallationBundle\Model\PartStateInterface'),
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\InstallationBundle\Model\PartInterface', $this->entity);
    }
    
    public function testGetName()
    {
        $this->assertSame('foo',$this->entity->getName());
    }
    
    public function testGetCategory()
    {
        $this->assertSame($this->category, $this->entity->getCategory());
    }
    
    public function testGetStates()
    {
        $this->assertCount(2, $this->entity->getStates());
    }
}