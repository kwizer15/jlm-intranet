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
use JLM\ProductBundle\Entity\ProductCategory;
use JLM\ProductBundle\Model\ProductCategoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductCategoryTest extends TestCase
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
        $parent = $this->createMock(ProductCategoryInterface::class);
        $this->assertSame($this->entity, $this->entity->setParent($parent));
        $this->assertSame($parent, $this->entity->getParent());
    }
    
    public function testChildren()
    {
        $child = $this->createMock(ProductCategoryInterface::class);
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
}
