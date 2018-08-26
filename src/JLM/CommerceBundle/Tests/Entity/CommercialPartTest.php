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
class CommercialPartTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mock CommercialPart
     */
    protected $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = $this->getMockForAbstractClass('JLM\CommerceBundle\Entity\CommercialPart');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
         $this->assertInstanceOf('JLM\CommerceBundle\Model\CommercialPartInterface', $this->entity);
    }
    
    public function getAttributes()
    {
        return [
            ['Creation', $this->getMock('DateTime')],
            ['Number', '123456'],
            ['Customer', $this->getMock('JLM\CommerceBundle\Model\CustomerInterface')],
            ['CustomerName', 'Foo'],
            ['CustomerAddress', 'Bar'],
            ['Vat', 19.6],
            
            // Deprecated
            ['Trustee',  $this->getMock('JLM\CommerceBundle\Model\CustomerInterface')],
            ['TrusteeName', 'Foo'],
            ['TrusteeAddress', 'Bar'],
            ['VatTransmitter', 19.6],
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
