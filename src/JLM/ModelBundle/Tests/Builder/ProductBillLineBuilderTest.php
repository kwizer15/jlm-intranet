<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Tests\Builder;

use JLM\ModelBundle\Builder\ProductBillLineBuilder;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductBillLineBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $builder;
    
    private $product;
    
    private $categoryId;
    
    private $vat;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->product = $this->getMock('JLM\ProductBundle\Model\ProductInterface');
        
        $this->product->expects($this->any())->method('isSmallSupply')->will($this->returnValue(true));
        $this->vat = 0.2;
        $this->builder = new ProductBillLineBuilder($this->product, $this->vat);
        $this->builder->create();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\CommerceBundle\Builder\BillLineBuilderInterface', $this->builder);
    }
    
    /**
     * {@inheritdoc}
     */
    public function assertPostConditions()
    {
        $this->assertInstanceOf('JLM\CommerceBundle\Model\BillLineInterface', $this->builder->getLine());
    }
    
    public function testBuildQuantity()
    {
        $this->builder->buildQuantity();
        $this->assertSame(1, $this->builder->getLine()->getQuantity());
    }
    
    public function testBuildQuantityIntoConstruct()
    {
        $this->builder = new ProductBillLineBuilder($this->product, $this->vat, 2);
        $this->builder->create();
        $this->builder->buildQuantity();
        $this->assertSame(2, $this->builder->getLine()->getQuantity());
    }
    
    public function testBuildPriceByProduct()
    {
        $this->product->expects($this->once())->method('getUnitPrice')->will($this->returnValue(50.0));
        $this->builder->buildPrice();
        $this->assertEquals(50.0, $this->builder->getLine()->getUnitPrice());
        $this->assertEquals($this->vat, $this->builder->getLine()->getVat());
    }
    
    public function testBuildPriceIntoConstruct()
    {
        $this->builder = new ProductBillLineBuilder($this->product, 0.1, 1, array('price'=>10.2));
        $this->builder->create();
        $this->builder->buildPrice();
        $this->assertEquals(10.2, $this->builder->getLine()->getUnitPrice());
        $this->assertEquals(0.1, $this->builder->getLine()->getVat());
    }
    
    public function testBuildProduct()
    {
        $this->builder->buildProduct();
        $this->assertSame($this->product, $this->builder->getLine()->getProduct());
        $this->assertTrue($this->builder->getLine()->getIsTransmitter());
    }
}