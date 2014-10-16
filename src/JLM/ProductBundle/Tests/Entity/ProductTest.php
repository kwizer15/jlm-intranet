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

use JLM\ProductBundle\Entity\Product;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductTest extends \PHPUnit_Framework_TestCase
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
        $this->entity = new Product;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ProductBundle\Model\ProductInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
    
    public function testReference()
    {
        $this->assertSame($this->entity, $this->entity->setReference('Foo'));
        $this->assertSame('Foo', $this->entity->getReference());
    }
    
    public function testDesignation()
    {
        $this->assertSame($this->entity, $this->entity->setDesignation('Foo'));
        $this->assertSame('Foo', $this->entity->getDesignation());
    }
    
    public function testDescription()
    {
        $this->assertSame($this->entity, $this->entity->setDescription('Foo'));
        $this->assertSame('Foo', $this->entity->getDescription());
    }
    
    public function testCategory()
    {
        $category = $this->getMock('JLM\ProductBundle\Model\ProductCategoryInterface');
        $this->assertSame($this->entity, $this->entity->setCategory($category));
        $this->assertSame($category, $this->entity->getCategory());
    }
    
    public function testSmallSupply()
    {
        $category = $this->getMock('JLM\ProductBundle\Model\ProductCategoryInterface');
        $category->expects($this->once())->method('isSmallSupply')->will($this->returnValue(true));
        $this->entity->setCategory($category);
        $this->assertSame(true, $this->entity->isSmallSupply());
    }
    
    public function testService()
    {
        $category = $this->getMock('JLM\ProductBundle\Model\ProductCategoryInterface');
        $category->expects($this->once())->method('isService')->will($this->returnValue(true));
        $this->entity->setCategory($category);
        $this->assertSame(true, $this->entity->isService());
    }
}