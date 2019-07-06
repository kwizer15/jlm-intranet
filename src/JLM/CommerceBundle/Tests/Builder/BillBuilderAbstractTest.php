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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillBuilderAbstractTest extends \PHPUnit\Framework\TestCase
{
    private $builder;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->builder = $this->getMockForAbstractClass('JLM\CommerceBundle\Builder\BillBuilderAbstract');
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
    
    public function testBuildCreation()
    {
        $this->builder->buildCreation();
        $this->assertInstanceOf('DateTime', $this->builder->getBill()->getCreation());
    }
}