<?php

/*
 * This file is part of the JLMBillBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\BillBundle\Tests\Builder;

use JLM\BillBundle\Builder\BillFactory;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $builder;
    
    private $bill;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->builder = $this->getMock('JLM\BillBundle\Builder\BillBuilderInterface');
        
        $this->bill = null;
    }

    /**
     * {@inheritdoc}
     */
    public function assertPreConditions()
    {
        $this->builder->expects($this->once())->method('getBill')->will($this->returnValue($this->getMock('JLM\BillBundle\Model\BillInterface')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function assertPostConditions()
    {
        $this->assertInstanceOf('JLM\BillBundle\Model\BillInterface', $this->bill);
    }

    /**
     * @dataProvider builders
     */
    public function testBuilders($method)
    {
        $this->builder->expects($this->once())->method($method);
        $this->bill = BillFactory::create($this->builder);
    }
    
    public function builders()
    {
        return array(
        	array('create'),
            array('buildCreation'),
            array('buildCustomer'),
            array('buildBusiness'),
            array('buildReference'),
            array('buildIntro'),
            array('buildDetails'),
            array('buildConditions'),
            array('buildLines'),
            
        );
    }
}