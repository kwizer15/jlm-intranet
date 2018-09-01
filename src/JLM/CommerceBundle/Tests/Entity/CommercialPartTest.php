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
use JLM\CommerceBundle\Entity\CommercialPart;
use JLM\CommerceBundle\Model\CommercialPartInterface;
use JLM\CommerceBundle\Model\CustomerInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CommercialPartTest extends \PHPUnit\Framework\TestCase
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
        $this->entity = $this->getMockForAbstractClass(CommercialPart::class);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
         $this->assertInstanceOf(CommercialPartInterface::class, $this->entity);
    }
    
    public function getAttributes()
    {
        return [
                ['Creation',$this->createMock(\DateTime::class),],
                ['Number','123456',],
                ['Customer', $this->createMock(CustomerInterface::class),],
                ['CustomerName', 'Foo',],
                ['CustomerAddress', 'Bar',],
                ['Vat', 19.6,],
            
            // Deprecated
                ['Trustee', $this->createMock(CustomerInterface::class),],
                ['TrusteeName', 'Foo',],
                ['TrusteeAddress', 'Bar',],
                ['VatTransmitter', 19.6,],
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
