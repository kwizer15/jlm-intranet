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
	
    public function getNames()
    {
        return array(
            array('Foo', 'Foo'),
        );
    }
    
    /**
     * @dataProvider getNames
     * @param string $in
     * @param string $out
     */
    public function testName($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setName($in));
        $this->assertSame($out, $this->entity->getName());
        $this->assertSame($out, $this->entity->__toString());
    }
    
    public function getValidPhones()
    {
        return array(
            array('0119379665','0119379665'),
        );
    }
    
    /**
     * @dataProvider getValidPhones
     * @param string $in
     * @param string $out
     */
    public function testValidPhone($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setPhone($in));
        $this->assertSame($in, $this->entity->getPhone());
    }
    
    /**
     * @dataProvider getValidPhones
     * @param string $in
     * @param string $out
     */
    public function testValidFax($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setFax($in));
        $this->assertSame($in, $this->entity->getFax());
    }
    
    public function getValidEmails()
    {
        return array(
            array('0119379665','0119379665'),
        );
    }
    
    /**
     * @dataProvider getValidEmails
     * @param string $in
     * @param string $out
     */
    public function testEmail($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setEmail($in));
        $this->assertSame($out, $this->entity->getEmail());
    }
    
    public function getValidAddresses()
    {
        return array(
            array($this->getMock('JLM\ContactBundle\Model\AddressInterface')),
        );
    }
    
    /**
     * @dataProvider getValidAddresses
     * @param string $in
     * @param string $out
     */
    public function testValidAddress($in)
    {
        $this->assertSame($this->entity, $this->entity->setAddress($in));
        $this->assertSame($in, $this->entity->getAddress());
    }
    
    public function testAddContact()
    {
        $contact = $this->getMock('JLM\ContactBundle\Model\CorporationContactInterface');
        $this->assertTrue($this->entity->addContact($contact));
        $this->assertCount(1, $this->entity->getContacts());
    }
}