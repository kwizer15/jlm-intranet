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
        
        $door = $this->getMock('JLM\ModelBundle\Entity\Door');
        $vat = $this->getMock('JLM\CommerceBundle\Model\VATInterface');
        $vat->expects($this->any())->method('getRate')->will($this->returnValue('0.20'));
        $address = $this->getMock('JLM\ContactBundle\Model\AddressInterface');
        $address->expects($this->any())->method('toString')->will($this->returnValue('Foo'));
        $trustee = $this->getMock('JLM\ModelBundle\Entity\Trustee');
        $trustee->expects($this->any())->method('getBillAddress')->will($this->returnValue($address));
        $contract = $this->getMock('JLM\ContractBundle\Model\ContractInterface');
        $contract->expects($this->any())->method('getManager')->will($this->returnValue($trustee));
        $contract->expects($this->any())->method('getTrustee')->will($this->returnValue($trustee));   // @deprecated
        $site = $this->getMock('JLM\ModelBundle\Entity\Site');
        $site->expects($this->any())->method('getTrustee')->will($this->returnValue($trustee));  // @deprecated
        $site->expects($this->any())->method('getManager')->will($this->returnValue($trustee));
        $site->expects($this->any())->method('getVat')->will($this->returnValue($vat));
        $door->expects($this->any())->method('getSite')->will($this->returnValue($site));  // @deprecated
        $door->expects($this->any())->method('getAdministrator')->will($this->returnValue($site));  
        $door->expects($this->any())->method('getActualContract')->will($this->returnValue($contract));
        $ask = $this->getMock('JLM\OfficeBundle\Entity\AskQuote');
        $ask->expects($this->any())->method('getSite')->will($this->returnValue($site));  // @deprecated
        $ask->expects($this->any())->method('getAdministrator')->will($this->returnValue($site));  
        $ask->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        $quote = $this->getMock('JLM\CommerceBundle\Model\QuoteInterface');
        $quote->expects($this->any())->method('getAsk')->will($this->returnValue($ask));
        $quote->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        
        $this->variant = $this->getMock('JLM\CommerceBundle\Model\QuoteVariantInterface');
        $this->variant->expects($this->any())->method('getNumber')->will($this->returnValue('14120001-1'));
        $this->variant->expects($this->any())->method('getQuote')->will($this->returnValue($quote));
        $this->variant->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        $this->variant->expects($this->any())->method('getLines')->will($this->returnValue(array()));
        $this->builder = new VariantBillBuilder($this->variant);
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
        $this->assertEquals('Selon votre accord sur notre devis n°14120001-1', $this->builder->getBill()->getReference());
    }
    
    public function testBuildDetails()
    {
        $door = $this->getMock('JLM\ModelBundle\Entity\Door');
        $this->variant->expects($this->any())->method('getDoor')->will($this->returnValue($door));
        $this->builder->buildDetails();
    }
}