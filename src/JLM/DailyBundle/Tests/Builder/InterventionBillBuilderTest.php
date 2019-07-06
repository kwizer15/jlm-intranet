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
use JLM\ModelBundle\Entity\Door;
use JLM\CommerceBundle\Model\VATInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ContractBundle\Model\ContractInterface;
use JLM\ModelBundle\Entity\Site;
use JLM\DailyBundle\Entity\Intervention;
use JLM\CommerceBundle\Builder\BillBuilderInterface;
use JLM\CommerceBundle\Model\BillInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionBillBuilderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var InterventionBillBuilder
     */
    private $builder;

    /**
     * @var Intervention
     */
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
        $trustee->method('getBillAddress')->willReturn($address);
        $contract = $this->createMock(ContractInterface::class);
        $contract->method('getManager')->willReturn($trustee);
        $site = $this->createMock(Site::class);
        $site->method('getManager')->willReturn($trustee);
        $site->method('getVat')->willReturn($vat);
        $door->method('getAdministrator')->willReturn($site);
        $door->method('getActualContract')->willReturn($contract);
        
        $this->intervention = $this->createMock(Intervention::class);
        $this->intervention->method('getLastDate')->willReturn(new \DateTime);
        $this->intervention->method('getReason')->willReturn([]);
        $this->intervention->method('getDoor')->willReturn($door);
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