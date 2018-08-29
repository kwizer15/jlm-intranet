<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Tests\Factory;

use JLM\CommerceBundle\Factory\BillFactory;

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
        $this->builder = $this->getMock('JLM\CommerceBundle\Builder\BillBuilderInterface');

        $this->bill = null;
    }

    /**
     * {@inheritdoc}
     */
    public function assertPreConditions()
    {
        $this->builder->expects($this->once())->method('getBill')->will(
            $this->returnValue($this->getMock('JLM\CommerceBundle\Model\BillInterface'))
        )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function assertPostConditions()
    {
        $this->assertInstanceOf('JLM\CommerceBundle\Model\BillInterface', $this->bill);
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
        return [
            ['create'],
            ['buildCreation'],
            ['buildCustomer'],
            ['buildBusiness'],
            ['buildReference'],
            ['buildIntro'],
            ['buildDetails'],
            ['buildConditions'],
            ['buildLines'],

        ];
    }
}
