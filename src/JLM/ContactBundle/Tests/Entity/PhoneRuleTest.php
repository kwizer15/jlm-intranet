<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\PhoneRule;
use JLM\ContactBundle\Entity\PhoneRuleException;
use JLM\ContactBundle\Entity\Country;

class PhoneRuleTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testId()
	{
		$entity = new PhoneRule;
		$this->assertNull($entity->getId());
	}
	
	/**
	 * @test
	 */
	public function testCountry()
	{
		$entity = new PhoneRule;
		$country = new Country;
		
		$this->assertNull($entity->getCountry());

		$this->assertEquals($entity,$entity->setCountry($country));
		$this->assertEquals($country,$entity->getCountry());
		$this->assertInstanceOf('\JLM\ContactBundle\Entity\Country', $entity->getCountry());
		
		$this->assertEquals($entity,$entity->setCountry());
		$this->assertNull($entity->getCountry());
	}
	
	/**
	 * @test
	 */
	public function testCode()
	{
		$entity = new PhoneRule;
		$this->assertEquals(0,$entity->getCode());
		$this->assertInternalType('int',$entity->getCode());
		
		$tests = array(
				array(0,0),
				array(1,1),
				array(-1,null),
				array(9999,9999),
				array(10000,null),
				array('salut',null),
				array(array('youpi'),null),
				array(new PhoneRule,null),
		);
		foreach ($tests as $test)
		{
			try {
				$this->assertEquals($entity,$entity->setCode($test[0]));
			} catch (PhoneRuleException $e) {
				if ($test[1] !== null)
					$this->fail('Une exception non attendue a été levée : '.$test[0]);
				continue;
			}
			if ($test[1] === null)
				$this->fail('Une exception attendue n\'a pas été levée : '.$test[0]);
			else {
				$this->assertEquals($test[1],$entity->getCode());
				$this->assertInternalType('int',$entity->getCode());
			}
		}
	}
	
	/**
	 * @test
	 */
	public function testLocalCode()
	{
		$entity = new PhoneRule;
		$this->assertNull($entity->getLocalCode());
		
		$tests = array(
				array(0,0),
				array(1,1),
				array(-1,null),
				array(9999,9999),
				array(10000,null),
				array('salut',null),
				array(new PhoneRule,null),
		);
		foreach ($tests as $test)
		{
			try
			{
				$this->assertEquals($entity,$entity->setLocalCode($test[0]));
			}
			catch (PhoneRuleException $e)
			{
				if ($test[1] !== null)
					$this->fail('Une exception non attendue a été levée : '.$test[0]);
				continue;
			}
			if ($test[1] === null)
				$this->fail('Une exception attendue n\'a pas été levée : '.$test[0]);
			else {
				$this->assertEquals($test[1],$entity->getLocalCode());
				$this->assertInternalType('int',$entity->getLocalCode());
			}
		}
	}
	
	/**
	 * @test
	 */
	public function testFormat()
	{
		$entity = new PhoneRule;
		$this->assertNull($entity->getFormat());
		
		$tests = array(
				array('IN NN NN NN NN','IN NN NN NN NN'),
				array('NN 0F GH CC LL',null),
				array('0 123-456 789-ILN','0 123-456 789-ILN'),
				array('0 123-456 789-LN',null),
				array('0 123-456 789-IILN',null),
				array('0 123-456 789-II',null),
				array('014',null),
				array(new PhoneRule,null),
		);
		foreach ($tests as $test)
		{
			try {
				$this->assertEquals($entity,$entity->setFormat($test[0]));
			} catch (PhoneRuleException $e) {
				if ($test[1] !== null)
					$this->fail('Une exception non attendue a été levée : '.$test[0]);
				continue;
			}
			if ($test[1] === null)
				$this->fail('Une exception attendue n\'a pas été levée : '.$test[0]);
			$this->assertEquals($test[1],$entity->getFormat());
			$this->assertInternalType('string',$entity->getFormat());
		}
	}
	
	/**
	 * @test
	 */
	public function testGetRegex()
	{
		$entity = new PhoneRule;
		$tests = array(
				array('IN NN NN NN NN','#^(000|\+0)?[0-9] ?[0-9][0-9] ?[0-9][0-9] ?[0-9][0-9] ?[0-9][0-9]$#'),
				array('0 123-456 789-ILN','#^0 ?123-?456 ?789-?(000|\+0)?[A-Z][0-9]$#'),
		);
		foreach ($tests as $test)
		{
			$this->assertEquals($entity,$entity->setFormat($test[0]));
			$this->assertEquals($test[1],$entity->getRegex());
			$this->assertInternalType('string',$entity->getRegex());
		}
		$entity->setLocalCode(0);	// Pour la lettre I
		$entity->setCode(33);
		$tests = array(
				array('IN NN NN NN NN','#^(0|0033|\+33)[0-9] ?[0-9][0-9] ?[0-9][0-9] ?[0-9][0-9] ?[0-9][0-9]$#'),
				array('0 123-456 789-ILN','#^0 ?123-?456 ?789-?(0|0033|\+33)[A-Z][0-9]$#'),
		);
		foreach ($tests as $test)
		{
			$this->assertEquals($entity,$entity->setFormat($test[0]));
			$this->assertEquals($test[1],$entity->getRegex());
			$this->assertInternalType('string',$entity->getRegex());
		}
	}

}