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

use JLM\ProductBundle\Entity\SupplierPurchasePrice;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SupplierPurchasePriceTest extends \PHPUnit_Framework_TestCase
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
        $this->entity = new SupplierPurchasePrice();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ProductBundle\Model\SupplierPurchasePriceInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
    

    
    /**
     * @return array
     */
    public function getValidPrices()
    {
    	return array(
    			array(0.0),
    			array(10.5),
    			array(152350.0),
    			array(15.253),
    			array(99.99),
    	);
    }
    
    /**
     * @return array
     */
    public function getBadPrices()
    {
    	return array(
    			array(-10.0),
    			array('Foo'),
    			array(null),
    			array(array('Foo')),
    	);
    }

    /**
     * @return array
     */
    public function getValidDiscounts()
    {
    	return array(
    			array(  100,   0   , 100  ),
    			array(   50,   0.0 ,  50  ),
    			array(  100,  50.5 ,  49.5),
    			array( 1000,  45.58, 544.2),
    			array(20000,  99.99,   2  ),
    			array(   80, 100.00,   0  ),
    	);
    }

    /**
     * @return array
     */
    public function getBadDiscounts()
    {
    	return array(
    			array(-10),
    			array(100.1),
    			array(101),
    			array(-0.1),
    			array('Foo'),
    			array(null),
    			array(array('Foo')),
    	);
    }
    
    /**
     * @return array
     */
    public function getValidExpenseRatios()
    {
    	return array(
    			array(0),
    			array(0.0),
    			array(50.5),
    			array(45.58),
    			array(99.9999),
    			array(100.00),
    			array(105.00),
    			array(1000.00),
    	);
    }   

    /**
     * @return array
     */
    public function getBadExpenseRatios()
    {
    	return array(
    			array(-10),
    			array(-0.1),
    			array('Foo'),
    			array(null),
    			array(array('Foo')),
    	);
    }
    
    public function testReference()
    {
    	$reference = 'Foo';
    	$this->assertSame($this->entity, $this->entity->setReference($reference));
    	$this->assertSame($reference, $this->entity->getReference());
    }
    
    /**
     * @dataProvider getValidPrices
     */
    public function testValidUnitPrice($price)
    {
        $this->assertSame($this->entity, $this->entity->setUnitPrice($price));
        $this->assertEquals($price, $this->entity->getUnitPrice());
        $this->assertEquals($price, $this->entity->getPublicPrice());
    }

    /**
     * @dataProvider getBadPrices
     */
    public function testBadUnitPrice($price)
    {
    	$this->assertSame($this->entity, $this->entity->setUnitPrice($price));
    	$this->assertEquals(0, $this->entity->getUnitPrice());
    }
    
    /**
     * @dataProvider getValidPrices
     */
    public function testValidPublicPrice($price)
    {
    	$this->assertSame($this->entity, $this->entity->setPublicPrice($price));
    	$this->assertEquals($price, $this->entity->getPublicPrice());
    	$this->assertEquals($price, $this->entity->getUnitPrice());
    }
    
    /**
     * @dataProvider getBadPrices
     */
    public function testBadPublicPrice($price)
    {
    	$this->assertSame($this->entity, $this->entity->setPublicPrice($price));
    	$this->assertEquals(0, $this->entity->getPublicPrice());
    }
    
    /**
     * @dataProvider getValidPrices
     */
    public function testValidExpense($price)
    {
    	$this->assertSame($this->entity, $this->entity->setExpense($price));
    	$this->assertEquals($price, $this->entity->getExpense());
    }
    
    /**
     * @dataProvider getBadPrices
     */
    public function testBadExpense($price)
    {
    	$this->assertSame($this->entity, $this->entity->setExpense($price));
    	$this->assertEquals(0, $this->entity->getExpense());
    }
    
    /**
     * @dataProvider getValidDiscounts
     */
    public function testValidDiscount($publicPrice, $discount, $unitPrice)
    {
    	$this->entity->setPublicPrice($publicPrice);
        $this->assertSame($this->entity, $this->entity->setDiscount($discount));
        $this->assertEquals($discount, $this->entity->getDiscount());
        $this->assertEquals($unitPrice, $this->entity->getUnitPrice());
    }
 
    /**
     * @dataProvider getBadDiscounts
     */
    public function testBadDiscount($discount)
    {
    	$this->assertSame($this->entity, $this->entity->setDiscount($discount));
    	$this->assertEquals(0, $this->entity->getDiscount());
    }

    /**
     * @dataProvider getValidExpenseRatios
     */
    public function testValidExpenseRatio($ratio)
    {
    	$this->entity->setPublicPrice(1000.0);
    	$this->assertSame($this->entity, $this->entity->setExpenseRatio($ratio));
    	$this->assertEquals($ratio, $this->entity->getExpenseRatio());
    }
    
    /**
     * @dataProvider getBadExpenseRatios
     */
    public function testBadExpenseRatio($ratio)
    {
    	$this->assertSame($this->entity, $this->entity->setExpenseRatio($ratio));
    	$this->assertEquals(0, $this->entity->getExpenseRatio());
    }
    
    /**
     * @dataProvider getValidPrices
     */
    public function testValidDelivery($delivery)
    {
        $this->assertSame($this->entity, $this->entity->setDelivery($delivery));
        $this->assertSame($delivery, $this->entity->getDelivery());
    }
    
    /**
     * @dataProvider getBadPrices
     */
    public function testBadDelivery($delivery)
    {
    	$this->assertSame($this->entity, $this->entity->setDelivery($delivery));
    	$this->assertEquals(0, $this->entity->getDelivery());
    }
    
    /**
     * @return array
     */
    public function getPurchases()
    {
        return array(
        	array(100, 20, 10, 2, 90),
            array(  0, 20, 10, 2,  2),
        );
    }
    
    /**
     * @dataProvider getPurchases
     * @param float $unitPrice
     * @param float $discount
     * @param float $expenseRatio
     * @param float $delivery
     * @param float $totalPrice
     */
    public function testTotalPrice($publicPrice, $discount, $expenseRatio, $delivery, $totalPrice)
    {
        $this->entity->setPublicPrice($publicPrice);
        $this->entity->setDiscount($discount);
        $this->entity->setExpenseRatio($expenseRatio);
        $this->entity->setDelivery($delivery);
        $this->assertEquals($totalPrice, $this->entity->getTotalPrice());
    }
    
    public function testSupplier()
    {
        $supplier = $this->getMock('JLM\ProductBundle\Model\SupplierInterface');
        $this->assertSame($this->entity, $this->entity->setSupplier($supplier));
        $this->assertSame($supplier, $this->entity->getSupplier());
    }

}