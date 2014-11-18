<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Company;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CompanyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Person
     */
    protected $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Company;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\CompanyInterface', $this->entity);
        $this->assertNull($this->entity->getId());
        $this->assertCount(0, $this->entity->getContacts());
    }

    public function getAttributes()
    {
        return array(
            array('Name', 'Foo'),
            array('Email', 'commerce@jlm-entreprise.fr'),
            array('Address', $this->getMock('JLM\ContactBundle\Model\AddressInterface')),
        );
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
    
    public function getAdderRemover()
    {
        return array(
            array('Phone', 'Phones', $this->getMock('JLM\ContactBundle\Model\PhoneInterface')),
            array('Contact', 'Contacts', $this->getMock('JLM\ContactBundle\Model\CorporationContactInterface')),
        );
    }
    
    /**
     * @dataProvider getAdderRemover
     */
    public function testAdderRemover($attribute, $attributes, $value)
    {
        $getters = 'get'.$attributes;
        $adder = 'add'.$attribute;
        $remover = 'remove'.$attribute;
        $this->assertCount(0, $this->entity->$getters());
        $this->assertFalse($this->entity->$remover($value));
        $this->assertTrue($this->entity->$adder($value));
        $this->assertCount(1, $this->entity->$getters());
        $this->assertTrue($this->entity->$remover($value));
        $this->assertCount(0, $this->entity->$getters());
    }
}