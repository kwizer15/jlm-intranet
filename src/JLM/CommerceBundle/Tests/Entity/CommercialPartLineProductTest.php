<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Tests\Entity;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CommercialPartLineProductTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mock CommercialPartLineProduct
     */
    protected $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = $this->getMockForAbstractClass('JLM\CommerceBundle\Entity\CommercialPartLineProduct');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
         $this->assertInstanceOf('JLM\CommerceBundle\Model\CommercialPartLineInterface', $this->entity);
    }
    
    public function getAttributes()
    {
        return [
                [
                 'Position',
                 1,
                ],
                [
                 'Product',
                 $this->getMock('JLM\ProductBundle\Model\ProductInterface'),
                ],
                [
                 'Reference',
                 'Foo',
                ],
                [
                 'Designation',
                 'Foo',
                ],
                [
                 'Description',
                 'Bar',
                ],
                [
                 'ShowDescription',
                 true,
                ],
                [
                 'IsTransmitter',
                 false,
                ],
                [
                 'Quantity',
                 2,
                ],
                [
                 'UnitPrice',
                 25.50,
                ],
                [
                 'Discount',
                 0.1,
                ],
                [
                 'Vat',
                 20.0,
                ],
               ];
    }
    
    /**
     * Test getters and setters
     * @param string $attribute
     * @param mixed $value
     * @dataProvider getAttributes
     */
    public function testGettersSetters($attribute, $value)
    {
        $getter = 'get'.$attribute;
        $setter = 'set'.$attribute;
        $this->assertSame($this->entity, $this->entity->$setter($value));
        $this->assertSame($value, $this->entity->$getter());
    }
}
