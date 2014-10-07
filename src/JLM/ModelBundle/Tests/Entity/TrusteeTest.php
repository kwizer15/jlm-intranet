<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Tests\Entity;

use JLM\ModelBundle\Entity\Trustee;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class TrusteeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Country
     */
    protected $entity;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->entity = new Trustee;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
         
    }
    
    public function testBillingAddressAsNull()
    {
        $address = $this->getMock('JLM\ContactBundle\Model\AddressInterface');
        $this->assertSame($this->entity, $this->entity->setAddress($address));
        $this->assertSame($this->entity, $this->entity->setBillingAddress());
        $this->assertSame($address, $this->entity->getBillingAddress());
    }
    
    public function testBillingAddress()
    {
        $address = $this->getMock('JLM\ContactBundle\Model\AddressInterface');
        $this->assertSame($this->entity, $this->entity->setBillingAddress($address));
        $this->assertSame($address, $this->entity->getBillingAddress());
    }
}