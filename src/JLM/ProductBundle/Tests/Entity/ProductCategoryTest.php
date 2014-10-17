<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Tests\Entity;

use JLM\ProductBundle\Entity\ProductCategory;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductCategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Product
     */
    protected $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new ProductCategory;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ProductBundle\Model\ProductCategoryInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
    
    public function testParent()
    {
        $parent = $this->getMock('JLM\ProductBundle\Model\ProductCategoryInterface');
        $this->assertSame($this->entity, $this->entity->setParent($parent));
        $this->assertSame($parent, $this->entity->getParent());
    }
    
    public function testChildren()
    {
        $child = $this->getMock('JLM\ProductBundle\Model\ProductCategoryInterface');
        $this->assertCount(0, $this->entity->getChildren());
        $this->assertTrue($this->entity->addChild($child));
        $this->assertCount(1, $this->entity->getChildren());
        $this->assertTrue($this->entity->removeChild($child));
        $this->assertCount(0, $this->entity->getChildren());
    }
    
    public function testName()
    {
        $this->assertSame($this->entity, $this->entity->setName('Foo'));
        $this->assertSame('Foo', $this->entity->getName());
        $this->assertSame('Foo', $this->entity->__toString());
    }
    
    public function testSmallSupply()
    {
        $entity = $this->getMockForAbstractClass('JLM\ProductBundle\Entity\ProductCategory');
        $entity->expects($this->any())->method('getId');
        $entity->isSmallSupply();
    }

    public function testService()
    {
        $entity = $this->getMockForAbstractClass('JLM\ProductBundle\Entity\ProductCategory');
        $entity->expects($this->any())->method('getId');
        $entity->isService();
    }
    
    /**
     * @deprecated
     */
    public function testAddProductCategory()
    {
        $entity = $this->getMockForAbstractClass('JLM\ProductBundle\Entity\ProductCategory');
        $entity->expects($this->any())->method('addChild');
        $this->assertTrue($entity->addProductCategory($this->entity));
    }
    
    /**
     * @deprecated
     */
    public function testRemoveProductCategory()
    {
        $entity = $this->getMockForAbstractClass('JLM\ProductBundle\Entity\ProductCategory');
        $entity->expects($this->any())->method('removeChild');
        $this->assertFalse($entity->removeProductCategory($this->entity));
    }
}