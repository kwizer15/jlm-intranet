<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Test;

use JLM\TransmitterBundle\Builder\AttributionBillBuilder;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AttributionBillBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $builder;
    
    private $attribution;
    
    private $vat;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->attribution = $this->getMock('JLM\TransmitterBundle\Entity\Attribution');
        $this->vat = 0.2;
        $this->builder = new AttributionBillBuilder($this->attribution, $this->vat);
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
        $category = $this->getMock('JLM\ProductBundle\Model\ProductCategoryInterface');
        $category->expects($this->any())->method('isSmallSupply')->will($this->returnValue(1));
        
        $product = $this->getMock('JLM\ProductBundle\Model\ProductInterface');
        $product->expects($this->any())->method('getCategory')->will($this->returnValue($category));
        
        $model = $this->getMock('JLM\TransmitterBundle\Entity\Model');
        $model->expects($this->any())->method('getId')->will($this->returnValue(1));
        $model->expects($this->any())->method('getProduct')->will($this->returnValue($product));
        
        $t1 = $this->getMock('JLM\TransmitterBundle\Model\TransmitterInterface');
        $t1->expects($this->any())->method('getModel')->will($this->returnValue($model));
        $t1->expects($this->any())->method('getNumber')->will($this->returnValue(152000));
        
        $t2 = $this->getMock('JLM\TransmitterBundle\Model\TransmitterInterface');
        $t2->expects($this->any())->method('getModel')->will($this->returnValue($model));
        $t2->expects($this->any())->method('getNumber')->will($this->returnValue(152000));
        
        $transmitters = array($t1, $t2);
        $this->attribution->expects($this->any())->method('getTransmitters')->will($this->returnValue($transmitters));
        $this->builder->buildLines();
    }
    
    public function testBuildBusiness()
    {
        $vat = $this->getMock('JLM\CommerceBundle\Model\VATInterface');
        $vat->expects($this->any())->method('getRate')->will($this->returnValue(0.2));
        
        $site = $this->getMock('JLM\ModelBundle\Entity\Site');
        $site->expects($this->any())->method('toString')->will($this->returnValue('Foo'));
        $site->expects($this->any())->method('getVat')->will($this->returnValue($vat));
        
        $this->attribution->expects($this->any())->method('getSite')->will($this->returnValue($site));
        $this->builder->buildBusiness();
    }
    
    public function testBuildConditions()
    {
        $this->builder->buildConditions();
        $this->assertInternalType('float', $this->builder->getBill()->getVatTransmitter());
    }
}