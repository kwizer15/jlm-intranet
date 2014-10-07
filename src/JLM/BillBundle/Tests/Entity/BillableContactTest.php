<?php

/*
 * This file is part of the JLMBillBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\BillBundle\Tests\Entity;

use JLM\BillBundle\Entity\BillableContact;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillableContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->contact = $this->getMock('JLM\ContactBundle\Model\ContactInterface');
        $this->entity = new BillableContact($this->contact);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\BillBundle\Model\BillableContactInterface', $this->entity);
    }
    
    public function testBillingBoostContacts()
    {
        $contact = $this->getMock('JLM\BillBundle\Model\BoostContactInterface');
        $this->assertCount(0, $this->entity->getBillingBoostContacts());
        $this->assertFalse($this->entity->removeBillingBoostContact($contact));
        $this->assertCount(0, $this->entity->getBillingBoostContacts());
        $this->assertTrue($this->entity->addBillingBoostContact($contact));
        $this->assertCount(1, $this->entity->getBillingBoostContacts());
        $this->assertTrue($this->entity->removeBillingBoostContact($contact));
        $this->assertCount(0, $this->entity->getBillingBoostContacts());
    }
    
    public function getDecoFunctions()
    {
        return array(
            array('getName', 'Foo'),
            array('getAddress', 'Foo'),
            array('getEmail', 'Foo'),
            array('__toString', 'Foo'),
        );
    }
    
    /**
     * @dataProvider getDecoFunctions
     * @param string $func
     * @param string $returnValue
     */
    public function testDecoratorFunctions($func, $returnValue)
    {
        $this->contact->expects($this->once())->method($func)->will($this->returnValue($returnValue));
        $this->assertSame($returnValue, $this->entity->$func());
    }
}