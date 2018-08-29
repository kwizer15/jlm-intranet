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
use JLM\ProductBundle\Model\ProductCategoryInterface;
use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\ProductPriceInterface;
use JLM\ProductBundle\Model\SupplierInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductTest extends \PHPUnit\Framework\TestCase
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
        $this->entity = new Product();
    }

    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf(ProductInterface::class, $this->entity);
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
        $this->assertSame('Foo', $this->entity->__toString());
    }

    public function testDescription()
    {
        $this->assertSame($this->entity, $this->entity->setDescription('Foo'));
        $this->assertSame('Foo', $this->entity->getDescription());
    }

    public function testCategory()
    {
        $category = $this->createMock(ProductCategoryInterface::class);
        $this->assertSame($this->entity, $this->entity->setCategory($category));
        $this->assertSame($category, $this->entity->getCategory());
    }

    public function testSmallSupply()
    {
        $category = $this->createMock(ProductCategoryInterface::class);
        $category->expects($this->once())->method('isSmallSupply')->will($this->returnValue(true));
        $this->entity->setCategory($category);
        $this->assertSame(true, $this->entity->isSmallSupply());
    }

    public function testService()
    {
        $category = $this->createMock(ProductCategoryInterface::class);
        $category->expects($this->once())->method('isService')->will($this->returnValue(true));
        $this->entity->setCategory($category);
        $this->assertSame(true, $this->entity->isService());
    }

    public function testUnitPrices()
    {
        $price = $this->createMock(ProductPriceInterface::class);
        $this->assertCount(0, $this->entity->getUnitPrices());
        $this->assertFalse($this->entity->removeUnitPrice($price));
        $this->assertCount(0, $this->entity->getUnitPrices());
        $this->assertTrue($this->entity->addUnitPrice($price));
        $this->assertCount(1, $this->entity->getUnitPrices());
        $this->assertTrue($this->entity->removeUnitPrice($price));
        $this->assertCount(0, $this->entity->getUnitPrices());
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
        return [
            [
                [
                    1,
                    25.0,
                ],
                [
                    5,
                    22.0,
                ],
                6,
                22.0,
            ],
            [
                [
                    1,
                    25.0,
                ],
                [
                    5,
                    22.0,
                ],
                5,
                22.0,
            ],
            [
                [
                    5,
                    25.0,
                ],
                [
                    10,
                    22.0,
                ],
                6,
                25.0,
            ],
            [
                [
                    5,
                    25.0,
                ],
                [
                    10,
                    22.0,
                ],
                11,
                22.0,
            ],
            [
                [
                    1,
                    25.0,
                ],
                [
                    5,
                    22.0,
                ],
                1,
                25.0,
            ],
        ];
    }

    /**
     * @dataProvider getUnitPrices
     *
     * @param array $p1
     * @param array $p2
     * @param int   $qty
     * @param float $price
     *
     * @throws \ReflectionException
     */
    public function testMultiUnitPrice($p1, $p2, $qty, $price)
    {
        $price1 = $this->createMock(ProductPriceInterface::class);
        $price1->expects($this->any())->method('getQuantity')->will($this->returnValue($p1[0]));
        $price1->expects($this->any())->method('getUnitPrice')->will($this->returnValue($p1[1]));

        $price2 = $this->createMock(ProductPriceInterface::class);
        $price2->expects($this->any())->method('getQuantity')->will($this->returnValue($p2[0]));
        $price2->expects($this->any())->method('getUnitPrice')->will($this->returnValue($p2[1]));

        $this->assertTrue($this->entity->addUnitPrice($price1));
        $this->assertTrue($this->entity->addUnitPrice($price2));
        $this->assertSame($price, $this->entity->getUnitPrice($qty));
    }

    public function testBarcode()
    {
        $barcode = '123456789';
        $this->assertSame($this->entity, $this->entity->setBarcode($barcode));
        $this->assertSame($barcode, $this->entity->getBarcode());
    }

    public function testPurchase()
    {
        $price = 12.34;
        $this->assertSame($this->entity, $this->entity->setPurchase($price));
        $this->assertSame($price, $this->entity->getPurchase());
    }

    public function testDiscountSupplier()
    {
        $discount = 12.34;
        $this->assertSame($this->entity, $this->entity->setDiscountSupplier($discount));
        $this->assertSame($discount, $this->entity->getDiscountSupplier());
    }

    public function testExpenseRatio()
    {
        $ratio = 12.34;
        $this->assertSame($this->entity, $this->entity->setExpenseRatio($ratio));
        $this->assertSame($ratio, $this->entity->getExpenseRatio());
    }

    public function testShipping()
    {
        $shipping = 12.34;
        $this->assertSame($this->entity, $this->entity->setShipping($shipping));
        $this->assertSame($shipping, $this->entity->getShipping());
    }

    public function testUnity()
    {
        $unity = 'pièce';
        $this->assertSame($this->entity, $this->entity->setUnity($unity));
        $this->assertSame($unity, $this->entity->getUnity());
    }

    /**
     * @return array
     */
    public function getPurchases()
    {
        return [
            [100, 20, 10, 2, 90, 99, 9, 225 / 22],
            [0, 20, 10, 2, 2, 99, 97, 0],
        ];
    }

    /**
     * @dataProvider getPurchases
     *
     * @param float $p
     * @param float $ds
     * @param float $er
     * @param float $s
     * @param float $res
     */
    public function testCalcs($p, $ds, $er, $s, $pp, $up, $m, $c)
    {
        $this->entity->setPurchase($p);
        $this->entity->setDiscountSupplier($ds);
        $this->entity->setExpenseRatio($er);
        $this->entity->setShipping($s);
        $this->assertEquals($pp, $this->entity->getPurchasePrice());

        $this->entity->setUnitPrice($up);
        $this->assertEquals($m, $this->entity->getMargin());
        $this->assertEquals($c, $this->entity->getCoef());
        $this->assertTrue($this->entity->isCoefPositive());
    }

    public function testSupplier()
    {
        $supplier = $this->createMock(SupplierInterface::class);
        $this->assertSame($this->entity, $this->entity->setSupplier($supplier));
        $this->assertSame($supplier, $this->entity->getSupplier());
    }
}
