<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\PhoneRule;

class PhoneRuleTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->country = $this->getMock('JLM\ContactBundle\Model\CountryInterface');
		$this->entity = new PhoneRule('IN NN NN NN NN', 33, 0, $this->country);		
	}
	
	public function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
		$this->assertSame($this->country,$this->entity->getCountry());
		$this->assertSame(33,$this->entity->getCode());
		$this->assertSame(0,$this->entity->getLocalCode());
		$this->assertSame('IN NN NN NN NN',$this->entity->getFormat());
	}
	
	public function providerCode()
	{
		return array(
				array(0,0),
				array(1,1),
				array(9999,9999),
		);
	}
	
	public function providerCodeException()
	{
		return array(
				array(-1),
				array(10000),
				array('salut'),
				array(array()),
				array(new \stdClass),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerCode
	 */
	public function testSetCode($in)
	{
		$this->assertSame($this->entity,$this->entity->setCode($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerCodeException
	 * @expectedException JLM\ContactBundle\Entity\PhoneRuleException
	 */
	public function testSetCodeException($in)
	{
		$this->entity->setCode($in);
	}
	
	/**
	 * @test
	 * @dataProvider providerCode
	 */
	public function testGetCode($in,$out)
	{
		$this->entity->setCode($in);
		$this->assertSame($out,$this->entity->getCode());
	}
	
	public function providerLocalCode()
	{
		return array(
				array(0,0),
				array(1,1),
				array(9999,9999),
		);
	}
	
	public function providerLocalCodeException()
	{
		return array(
				array(-1),
				array(10000),
				array('salut'),
				array(array()),
				array(new \stdClass),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerLocalCode
	 */
	public function testSetLocalCode($in)
	{
		$this->assertSame($this->entity,$this->entity->setLocalCode($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerLocalCodeException
	 * @expectedException JLM\ContactBundle\Entity\PhoneRuleException
	 */
	public function testSetLocalCodeException($in)
	{
		$this->entity->setLocalCode($in);
	}
	
	/**
	 * @test
	 * @dataProvider providerLocalCode
	 */
	public function testGetLocalCode($in,$out)
	{
		$this->entity->setLocalCode($in);
		$this->assertSame($out,$this->entity->getLocalCode());
	}
	
	public function providerFormat()
	{
		return array(
				array('IN NN NN NN NN','IN NN NN NN NN','#^(0|0033|\+33)[ \-\.,/]?[0-9][ \-\.,/]?[0-9][ \-\.,/]?[0-9][ \-\.,/]?[0-9][ \-\.,/]?[0-9][ \-\.,/]?[0-9][ \-\.,/]?[0-9][ \-\.,/]?[0-9][ \-\.,/]?[0-9]$#'),
				array('INLN LNLN-LNL N','INLN LNLN-LNL N','#^(0|0033|\+33)[ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9]$#'),
				array('   i  NlN    LnL n-LN   L N','I NLN LNL N-LN L N','#^(0|0033|\+33)[ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9][ \-\.,/]?[A-Z][ \-\.,/]?[0-9]$#'),
		);
	}
	
	public function providerFormatException()
	{
		return array(
				array('NN 0F GH CC LL'),
				array('0 123-456 789-ILN'),
				array('INNN1LLL'),
				array('014'),
				array(new \stdClass),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerFormat
	 */
	public function testSetFormat($in)
	{
		$this->assertSame($this->entity,$this->entity->setFormat($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerFormatException
	 * @expectedException JLM\ContactBundle\Entity\PhoneRuleException
	 */
	public function testSetFormatException($in)
	{
		$this->entity->setFormat($in);
	}
	
	/**
	 * @test
	 * @dataProvider providerFormat
	 */
	public function testGetFormat($in,$out)
	{
		$this->entity->setFormat($in);
		$this->assertSame($out,$this->entity->getFormat());
	}
	
	/**
	 * @test
	 * @dataProvider providerFormat
	 */
	public function testGetRegex($in,$out,$regex)
	{
		$this->entity->setFormat($in);
		$this->assertSame($regex,$this->entity->getRegex());
	}
	
	public function providerIsValid()
	{
		return array(
				array('IN NN NN NN NN','01 64 33 77 70'),
				array('IN NN NN NN NN','+33164337770'),
				array('IN NN NN NN NN','00331/64/33/77/70'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerIsValid
	 */
	public function testIsValid($format,$number)
	{
		$this->entity->setFormat($format);
		$this->assertTrue($this->entity->isValid($number));
	}
	
	public function providerIsNotValid()
	{
		return array(
				array('IN NN NN NN NN','01 64 33 77 710'),
				array('IN NN NN NN NN','+3316433777'),
				array('IN NN NN NN NN','0033A/64/33/77/70'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerIsNotValid
	 */
	public function testIsNotValid($format,$number)
	{
		$this->entity->setFormat($format);
		$this->assertFalse($this->entity->isValid($number));
	}
}