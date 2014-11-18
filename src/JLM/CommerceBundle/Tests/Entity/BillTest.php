<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Tests\Entity;

use JLM\CommerceBundle\Entity\Bill;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Bill
	 */
	protected $entity;
	
	/**
	 * {@inheritdoc}
	 */
	protected function setUp()
	{
		$this->entity = new Bill;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function assertPreConditions()
	{
		 $this->assertInstanceOf('JLM\CommerceBundle\Model\BillInterface', $this->entity);
		 $this->assertNull($this->entity->getId());
	}
	
	public function getAttributes()
	{
	    return array(
	    	array('Prelabel', 'Foo'),
	        array('Reference', 'Foo'),
	        array('AccountNumber', '123456'),
	        array('Details', 'Foo'),
	        array('Site', 'Foo'),
	        array('Property', 'Foo'),
	        array('EarlyPayment', 'Foo'),
	        array('Penalty', 'Foo'),
	        array('Intro', 'Foo'),
	        array('Maturity', 30),
	        array('State', 1),
	        array('Discount', 0.50),
	        array('Fee', $this->getMock('JLM\FeeBundle\Model\FeeInterface')),
	        array('FeesFollower', $this->getMock('JLM\FeeBundle\Model\FeesFollowerInterface')),
	        array('Intervention', $this->getMock('JLM\DailyBundle\Entity\Intervention')),
	        array('FirstBoost', $this->getMock('DateTime')),
	        array('SecondBoost', $this->getMock('DateTime')),
	        array('SecondBoostComment', 'Foo'),
	        array('SiteObject', $this->getMock('JLM\ModelBundle\Entity\Site')),
	    );
	}
	
	/**
	 * Test getters and setters
	 * @param string $attribute
	 * @param mixed $value
	 * @dataProvider getAttributes
	 */
	public function testGettersSetters($attribute, $value)
	{
	    $getter = 'get'.$attribute;
	    $setter = 'set'.$attribute;
	    $this->assertSame($this->entity, $this->entity->$setter($value));
	    $this->assertSame($value, $this->entity->$getter());
	}
}