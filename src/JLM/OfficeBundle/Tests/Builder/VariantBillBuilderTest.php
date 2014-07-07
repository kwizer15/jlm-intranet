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
        $this->variant = $this->getMock('JLM\OfficeBundle\Entity\QuoteVariant');
        $this->variant->expects($this->any())->method('getNumber')->will($this->returnValue('14120001-1'));
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
        $this->assertInstanceOf('JLM\OfficeBundle\Entity\Bill', $this->builder->getBill());
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
        $this->builder->buildDetails();
    }
}