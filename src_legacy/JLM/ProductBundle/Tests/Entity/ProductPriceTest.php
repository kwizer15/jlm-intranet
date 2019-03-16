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

use JLM\ProductBundle\Entity\ProductPrice;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductPriceTest extends \PHPUnit\Framework\TestCase
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
        $this->entity = new ProductPrice;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ProductBundle\Model\ProductPriceInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
    
    public function testProduct()
    {
        $product = $this->createMock('JLM\ProductBundle\Model\ProductInterface');
        $this->assertSame($this->entity, $this->entity->setProduct($product));
        $this->assertSame($product, $this->entity->getProduct());
    }
    
    public function testUnitPrice()
    {
        $this->assertSame($this->entity, $this->entity->setUnitPrice(12.34));
        $this->assertSame(12.34, $this->entity->getUnitPrice());
    }
    
    public function testQuantity()
    {
        $this->assertSame($this->entity, $this->entity->setQuantity(5));
        $this->assertSame(5, $this->entity->getQuantity());
    }
}
