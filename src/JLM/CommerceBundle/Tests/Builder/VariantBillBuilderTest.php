<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Tests\Builder;

use JLM\CommerceBundle\Builder\VariantBillBuilder;
use JLM\ModelBundle\Entity\Door;
use JLM\CommerceBundle\Model\VATInterface;
use JLM\ContactBundle\Model\AddressInterface;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ContractBundle\Model\ContractInterface;
use JLM\ModelBundle\Entity\Site;
use JLM\OfficeBundle\Entity\AskQuote;
use JLM\CommerceBundle\Model\QuoteInterface;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
use JLM\CommerceBundle\Builder\BillBuilderInterface;
use JLM\CommerceBundle\Model\BillInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantBillBuilderTest extends \PHPUnit\Framework\TestCase
{
    private $builder;
    
    private $variant;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        
        $door = $this->createMock(Door::class);
        $vat = $this->createMock(VATInterface::class);
        $vat->method('getRate')->willReturn('0.20');
        $address = $this->createMock(AddressInterface::class);
        $address->method('toString')->willReturn('Foo');
        $trustee = $this->createMock(Trustee::class);
        $trustee->method('getBillAddress')->willReturn($address);
        $contract = $this->createMock(ContractInterface::class);
        $contract->method('getManager')->willReturn($trustee);
        $site = $this->createMock(Site::class);
        $site->method('getManager')->willReturn($trustee);
        $site->method('getVat')->willReturn($vat);
        $door->method('getAdministrator')->willReturn($site);
        $door->method('getActualContract')->willReturn($contract);
        $ask = $this->createMock(AskQuote::class);
        $ask->method('getSite')->willReturn($site);  // @deprecated
        $ask->method('getDoor')->willReturn($door);
        $quote = $this->createMock(QuoteInterface::class);
        $quote->method('getAsk')->willReturn($ask);
        $quote->method('getDoor')->willReturn($door);
        
        $this->variant = $this->createMock(QuoteVariantInterface::class);
        $this->variant->method('getNumber')->willReturn('14120001-1');
        $this->variant->method('getQuote')->willReturn($quote);
        $this->variant->method('getDoor')->willReturn($door);
        $this->variant->method('getLines')->willReturn([]);
        $this->builder = new VariantBillBuilder($this->variant);
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
        $this->assertEquals('Selon votre accord sur notre devis n°14120001-1', $this->builder->getBill()->getReference());
    }
    
    public function testBuildDetails()
    {
        $door = $this->createMock(Door::class);
        $this->variant->method('getDoor')->willReturn($door);
        $this->builder->buildDetails();
    }
}