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
    
    public function testOneUnitPrice()
    {
        $this->assertSame($this->entity, $this->entity->setUnitPrice(12.34));
        $this->assertSame(12.34, $this->entity->getUnitPrice());
    }
    
    /**
     * @return array
     */
    public function getUnitPrices()
    {
        return array(
        	array(array(1, 25.0), array(5,22.0), 6, 22.0),
            array(array(1, 25.0), array(5,22.0), 5, 22.0),
            array(array(5, 25.0), array(10,22.0), 6, 25.0),
            array(array(5, 25.0), array(10,22.0), 11, 22.0),
            array(array(1, 25.0), array(5,22.0), 1, 25.0),
        );
    }
    
    /**
     * @dataProvider getUnitPrices
     * @param array $p1
     * @param array $p2
     * @param int $qty
     * @param float $price
     */
    public function testMultiUnitPrice($p1, $p2, $qty, $price)
    {
        $price1 = $this->getMock('JLM\ProductBundle\Model\ProductPriceInterface');
        $price1->expects($this->any())->method('getQuantity')->will($this->returnValue($p1[0]));
        $price1->expects($this->any())->method('getUnitPrice')->will($this->returnValue($p1[1]));
        
        $price2 = $this->getMock('JLM\ProductBundle\Model\ProductPriceInterface');
        $price2->expects($this->any())->method('getQuantity')->will($this->returnValue($p2[0]));
        $price2->expects($this->any())->method('getUnitPrice')->will($this->returnValue($p2[1]));
        
        $this->assertTrue($this->entity->addUnitPrice($price1));
        $this->assertTrue($this->entity->addUnitPrice($price2));
        $this->assertSame($price, $this->entity->getUnitPrice($qty));
    }
}