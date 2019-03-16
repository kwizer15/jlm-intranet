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

use JLM\CommerceBundle\Builder\BillBuilderInterface;
use JLM\CommerceBundle\Model\BillInterface;
use JLM\CommerceBundle\Model\VATInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContractBundle\Model\ContractInterface;
use JLM\DailyBundle\Builder\InterventionBillBuilder;
use JLM\DailyBundle\Entity\Intervention;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Trustee;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionBillBuilderTest extends \PHPUnit\Framework\TestCase
{
    private $builder;
    
    private $intervention;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        
        $door = $this->createMock(Door::class);
        $vat = $this->createMock(VATInterface::class);
        $address = $this->createMock(AddressInterface::class);
        $trustee = $this->createMock(Trustee::class);
        $trustee->expects($this->any())->method('getBillAddress')->will($this->returnValue($address));
        $contract = $this->createMock(ContractInterface::class);
        $contract->expects($this->any())->method('getManager')->will($this->returnValue($trustee));
        $site = $this->createMock(Site::class);
        $site->expects($this->any())->method('getManager')->will($this->returnValue($trustee));
        $site->expects($this->any())->method('getVat')->will($this->returnValue($vat));
        $door->expects($this->any())->method('getAdministrator')->will($this->returnValue($site));
        $door->expects($this->any())->method('getActualContract')->will($this->returnValue($contract));
        
        $this->intervention = $this->createMock(Intervention::class);
        $this->intervention->expects($this->any())->method('getLastDate')->will($this->returnValue(new \DateTime));
        $this->intervention->expects($this->any())->method('getReason')->will($this->returnValue([]));
        $this->intervention->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        $this->builder = new InterventionBillBuilder($this->intervention);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf(BillBuilderInterface::class, $this->builder);
        $this->builder->create();
    }
    
    /**
     * {@inheritdoc}
     */
    public function assertPostConditions()
    {
        $this->assertInstanceOf(BillInterface::class, $this->builder->getBill());
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
