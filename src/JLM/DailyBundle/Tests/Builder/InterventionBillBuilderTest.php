<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Tests\Builder;

use JLM\DailyBundle\Builder\InterventionBillBuilder;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionBillBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $builder;
    
    private $intervention;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        
        $door = $this->getMock('JLM\ModelBundle\Entity\Door');
        $vat = $this->getMock('JLM\CommerceBundle\Model\VATInterface');
        $address = $this->getMock('JLM\ContactBundle\Model\AddressInterface');
        $trustee = $this->getMock('JLM\ModelBundle\Entity\Trustee');
        $trustee->expects($this->any())->method('getBillAddress')->will($this->returnValue($address));
        $contract = $this->getMock('JLM\ContractBundle\Model\ContractInterface');
        $contract->expects($this->any())->method('getTrustee')->will($this->returnValue($trustee));
        $site = $this->getMock('JLM\ModelBundle\Entity\Site');
        $site->expects($this->any())->method('getTrustee')->will($this->returnValue($trustee));
        $site->expects($this->any())->method('getVat')->will($this->returnValue($vat));
        $door->expects($this->any())->method('getSite')->will($this->returnValue($site));
        $door->expects($this->any())->method('getActualContract')->will($this->returnValue($contract));
        
        $this->intervention = $this->getMock('JLM\DailyBundle\Entity\Intervention');
        $this->intervention->expects($this->any())->method('getLastDate')->will($this->returnValue(new \DateTime));
        $this->intervention->expects($this->any())->method('getReason')->will($this->returnValue(array()));
        $this->intervention->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        $this->builder = new InterventionBillBuilder($this->intervention);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\CommerceBundle\Builder\BillBuilderInterface', $this->builder);
        $this->builder->create();
    }
    
    /**
     * {@inheritdoc}
     */
    public function assertPostConditions()
    {
        $this->assertInstanceOf('JLM\CommerceBundle\Model\BillInterface', $this->builder->getBill());
    }
    
    public function testBuildLines()
    {
        $this->builder->buildLines();
    }
    
    public function testBuildBusiness()
    {
        $this->builder->buildBusiness();
    }
    
    public function testBuildConditions()
    {
        $this->builder->buildConditions();
    }
    
    public function testBuildCustomer()
    {
        $this->builder->buildCustomer();
    }
    
    public function testBuildReference()
    {
        $this->builder->buildReference();
//        $this->assertEquals('Selon notre intervention du ', $this->builder->getBill()->getReference());
    }
    
    public function testBuildDetails()
    {
        $this->builder->buildDetails();
    }
}