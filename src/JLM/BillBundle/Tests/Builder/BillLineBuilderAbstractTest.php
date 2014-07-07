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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillLineBuilderAbstractTest extends \PHPUnit_Framework_TestCase
{
    private $builder;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->builder = $this->getMockForAbstractClass('JLM\BillBundle\Builder\BillLineBuilderAbstract');
    }
    
    /**
     * {@inheritdoc}
     */
    protected function assertPreConditions()
    {
        $this->assertInstanceOf('JLM\BillBundle\Builder\BillLineBuilderInterface', $this->builder);
        $this->builder->create();
    }
    
    /**
     * {@inheritdoc}
     */
    public function assertPostConditions()
    {
        $this->assertInstanceOf('JLM\BillBundle\Model\BillLineInterface', $this->builder->getLine());
    }
    
    public function testBuildQuantity()
    {
        $this->builder->buildQuantity();
        $this->assertSame(1, $this->builder->getLine()->getQuantity());
    }
    
    public function testBuildPrice()
    {
        $this->builder->buildPrice();
        $this->assertEquals(0, $this->builder->getLine()->getUnitPrice());
    }
}