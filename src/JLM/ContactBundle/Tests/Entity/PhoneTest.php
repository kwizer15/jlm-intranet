<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Phone;
use JLM\ContactBundle\Entity\PhoneRule;
use JLM\ContactBundle\Entity\PhoneException;

class PhoneTest extends \PHPUnit_Framework_TestCase
{	
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->rule = $this->getMock('JLM\ContactBundle\Model\PhoneRuleInterface');
		
		
		$this->rule->expects($this->any())
				   ->method('getFormat')
				   ->will($this->returnValue('IN NN NN NN NN'));
		
		
		
		$this->rule->expects($this->any())
				   ->method('getCode')
		           ->will($this->returnValue(33));
		
		$this->rule->expects($this->any())
				   ->method('getLocalCode')
				   ->will($this->returnValue(0));
		
		$this->entity = new Phone($this->rule);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertSame($this->rule,$this->entity->getRule());
		$this->assertNull($this->entity->getNumber());
		$this->assertNull($this->entity->getId());
	}
	
	public function providerNumber()
	{
		return array(
				array('0164337770','01 64 33 77 70','+331 64 33 77 70'),
				array('  0.164.33-7/7 70','01 64 33 77 70','+331 64 33 77 70'),
				array('  0,,,.16 ..    4.3 3,-,,////,7/7   7,,,0   ','01 64 33 77 70','+331 64 33 77 70')
		);
	}
	
	public function testSetRule()
	{
		$rule = $this->getMock('JLM\ContactBundle\Model\PhoneRuleInterface');
		$this->entity->setRule($rule);
	}
	
	/**
	 * @test
	 * @dataProvider providerNumber
	 */
	public function testSetNumber($in)
	{
		$this->rule->expects($this->once())
					->method('isValid')
					->will($this->returnValue(true));
		$this->assertSame($this->entity,$this->entity->setNumber($in));
	}
	
	/**
	 * @test
	 * @expectedException JLM\ContactBundle\Entity\PhoneException
	 */
	public function testSetNumberException()
	{
		$this->rule->expects($this->once())
				   ->method('isValid')
		           ->will($this->returnValue(false));
		
		$this->entity->setNumber('foo');
	}
	
	/**
	 * @test
	 * @dataProvider providerNumber
	 */
	public function testGetNumber($in,$out,$out2)
	{
		$this->rule->expects($this->once())
					->method('isValid')
					->will($this->returnValue(true));
		
		$this->entity->setNumber($in);
		$this->assertSame($out,$this->entity->getNumber());
		$this->assertSame($out2,$this->entity->getNumber(false));
	}
	
	/**
	 * @test
	 * @dataProvider providerNumber
	 */
	public function test__toString($in,$out)
	{
		$this->rule->expects($this->once())
					->method('isValid')
					->will($this->returnValue(true));
		
		$this->entity->setNumber($in);
		$this->assertSame($out,$this->entity->__toString());
	}
}