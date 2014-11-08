<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Tests\Builder;

use JLM\OfficeBundle\Builder\VariantBillBuilder;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantBillBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $builder;
    
    private $variant;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $contract = $this->getMock('JLM\ContractBundle\Entity\ContractInterface');
        $door = $this->getMock('JLM\ModelBundle\Entity\Door');
        $vat = $this->getMock('JLM\ModelBundle\Entity\VAT');
        $address = $this->getMock('JLM\ContactBundle\Model\AddressInterface');
        $trustee = $this->getMock('JLM\ModelBundle\Entity\Trustee');
        $trustee->expects($this->any())->method('getAddressForBill')->will($this->returnValue($address));
        $site = $this->getMock('JLM\ModelBundle\Entity\Site');
        $site->expects($this->any())->method('getTrustee')->will($this->returnValue($trustee));
        $site->expects($this->any())->method('getVat')->will($this->returnValue($vat));
        $door->expects($this->any())->method('getSite')->will($this->returnValue($site));
        $ask = $this->getMock('JLM\OfficeBundle\Entity\AskQuote');
        $ask->expects($this->any())->method('getSite')->will($this->returnValue($site));
        $ask->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        $quote = $this->getMock('JLM\OfficeBundle\Entity\Quote');
        $quote->expects($this->any())->method('getAsk')->will($this->returnValue($ask));
        $quote->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        
        $this->variant = $this->getMock('JLM\OfficeBundle\Entity\QuoteVariant');
        $this->variant->expects($this->any())->method('getNumber')->will($this->returnValue('14120001-1'));
        $this->variant->expects($this->any())->method('getQuote')->will($this->returnValue($quote));
        $this->variant->expects($this->any())->method('getLines')->will($this->returnValue(array()));
        $this->builder = new VariantBillBuilder($this->variant);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\BillBundle\Builder\BillBuilderInterface', $this->builder);
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
        $this->assertEquals('Selon votre accord sur notre devis n°14120001-1', $this->builder->getBill()->getReference());
    }
    
    public function testBuildDetails()
    {
        $door = $this->getMock('JLM\ModelBundle\Entity\Door');
        $this->variant->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        $this->builder->buildDetails();
    }
}