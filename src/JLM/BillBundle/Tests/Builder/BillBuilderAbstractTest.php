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
class BillBuilderAbstractTest extends \PHPUnit_Framework_TestCase
{
    private $builder;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->builder = $this->getMockForAbstractClass('JLM\BillBundle\Builder\BillBuilderAbstract');
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
        $this->assertInstanceOf('JLM\BillBundle\Model\BillInterface', $this->builder->getBill());
    }
    
    public function testBuildCreation()
    {
        $this->builder->buildCreation();
        $this->assertInstanceOf('DateTime', $this->builder->getBill()->getCreation());
    }
}