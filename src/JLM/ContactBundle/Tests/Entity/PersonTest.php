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

use JLM\ContactBundle\Entity\Person;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PersonTest extends \PHPUnit_Framework_TestCase
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
        $this->entity = new Person;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\ContactBundle\Model\PersonInterface', $this->entity);
        $this->assertNull($this->entity->getId());
    }
	
    public function getTitles()
    {
        return array(
            array('M.', 'M.'),
            array('Mme', 'Mme'),
            array('Mlle', 'Mlle'),
        );
    }
    
    /**
     * @dataProvider getTitles
     * @param string $in
     * @param string $out
     */
    public function testTitle($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setTitle($in));
        $this->assertSame($out, $this->entity->getTitle());
    }
    
    public function getFirstNames()
    {
        return array(
            array('Foo', 'Foo'),
        );
    }
    
    /**
     * @dataProvider getFirstNames
     * @param string $in
     * @param string $out
     */
    public function testFirstName($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setFirstName($in));
        $this->assertSame($out, $this->entity->getFirstName());
    }
    
    public function getLastNames()
    {
        return array(
            array('Foo', 'Foo'),
        );
    }
    
    /**
     * @dataProvider getLastNames
     * @param string $in
     * @param string $out
     */
    public function testLastName($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setLastName($in));
        $this->assertSame($out, $this->entity->getLastName());
    }
    
    public function getNames()
    {
        return array(
        	array('M.', 'Emmanuel', 'Bernaszuk', 'M. Bernaszuk Emmanuel'),
            array('', 'Emmanuel', 'Bernaszuk', 'Bernaszuk Emmanuel'),
            array('M.', '', 'Bernaszuk', 'M. Bernaszuk'),
            array('M.', 'Emmanuel', '', 'M. Emmanuel'),
            array('', '', '', ''),
        );
    }
    
    /**
     * @dataProvider getNames
     * @param string $title
     * @param string $firstName
     * @param string $lastName
     * @param string $out
     */
    public function testName($title, $firstName, $lastName, $out)
    {
        $this->assertSame($this->entity, $this->entity->setTitle($title));
        $this->assertSame($this->entity, $this->entity->setFirstName($firstName));
        $this->assertSame($this->entity, $this->entity->setLastName($lastName));
        $this->assertSame($out, $this->entity->getName());
        $this->assertSame($out, $this->entity->__toString());
    }
    
    public function getRoles()
    {
        return array(
            array('Foo', 'Foo'),
        );
    }
    
    /**
     * @dataProvider getRoles
     * @param string $in
     * @param string $out
     */
    public function testRole($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setRole($in));
        $this->assertSame($out, $this->entity->getRole());
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
    public function testValidFixedPhone($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setFixedPhone($in));
        $this->assertSame($in, $this->entity->getFixedPhone());
    }
    
    /**
     * @dataProvider getValidPhones
     * @param string $in
     * @param string $out
     */
    public function testValidMobilePhone($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setMobilePhone($in));
        $this->assertSame($in, $this->entity->getMobilePhone());
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

    
    /**
     * @dataProvider getValidPhones
     * @param string $in
     * @param string $out
     */
    public function testFormatPhones($in, $out)
    {
        $this->assertSame($this->entity, $this->entity->setFixedPhone($in));
        $this->assertSame($this->entity, $this->entity->setMobilePhone($in));
        $this->assertSame($this->entity, $this->entity->setFax($in));
        $this->assertSame($this->entity, $this->entity->formatPhones());
        $this->assertSame($out, $this->entity->getFixedPhone());
        $this->assertSame($out, $this->entity->getMobilePhone());
        $this->assertSame($out, $this->entity->getFax());
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
            array(null),
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
}