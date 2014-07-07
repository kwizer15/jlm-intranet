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

use JLM\BillBundle\Builder\BillLineFactory;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillLineFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $builder;
    
    private $line;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->builder = $this->getMock('JLM\BillBundle\Builder\BillLineBuilderInterface');
        
        $this->line = null;
    }

    /**
     * {@inheritdoc}
     */
    public function assertPreConditions()
    {
        $this->builder->expects($this->once())->method('getLine')->will($this->returnValue($this->getMock('JLM\BillBundle\Model\BillLineInterface')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function assertPostConditions()
    {
        $this->assertInstanceOf('JLM\BillBundle\Model\BillLineInterface', $this->line);
    }

    /**
     * @dataProvider builders
     */
    public function testBuilders($method)
    {
        $this->builder->expects($this->once())->method($method);
        $this->line = BillLineFactory::create($this->builder);
    }
    
    public function builders()
    {
        return array(
        	array('create'),
            array('buildReference'),
            array('buildProduct'),
            array('buildQuantity'),
            array('buildPrice'),
        );
    }
}