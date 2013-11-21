<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Phone;
use JLM\ContactBundle\Entity\PhoneRule;
use JLM\ContactBundle\Entity\PhoneException;

class PhoneTest extends \PHPUnit_Framework_TestCase
{	
	/**
	 * @test
	 */
	public function testRule()
	{
		$entity = new Phone;
		$rule = new PhoneRule;
		$this->assertNull($entity->getRule());
		
		$tests = array(
			array($rule,$rule),
			array(true),
			array('INNNNN'),
			array(1),
		);
		
		foreach ($tests as $test)
		{
			try {
				$this->assertEquals($entity,$entity->setRule($test[0]));
			} catch (\Exception $e) {
				if (isset($test[1]))
					$this->fail('Une exception non attendue a été levée.');
				continue;
			}
			if (!isset($test[1]))
			{
				$this->fail('Une exception attendue n\'a pas été levée.');
				continue;
			}
			$this->assertEquals($test[1],$entity->getRule());
			$this->assertInstanceOf('\JLM\ContactBundle\Entity\PhoneRule',$entity->getRule());
		}
	}
	
	/**
	 * @test
	 */
	public function testNumber()
	{
		$entity = new Phone;
		$rule = new PhoneRule;
		$this->assertNull($entity->getNumber());
		
		
		$exception = false;
		try {
			$this->assertEquals($entity,$entity->setNumber('0164337770'));
		} catch (PhoneException $e) {
			// Pas de rule de définie
			$exception = true;
		}
		if (!$exception)
			$this->fail('Une exception attendue n\'a pas été levée');
		$this->assertNull($entity->getNumber());
		
		
		
		$exception = false;
		$entity->setRule($rule);
		try {
			$this->assertEquals($entity,$entity->setNumber('0164337770'));
		} catch (PhoneException $e) {
			// Pas de format rule de définie
			$exception = true;
		}
		if (!$exception)
			$this->fail('Une exception attendue n\'a pas été levée');
		
		
		$exception = false;
		$entity->getRule()->setFormat('IN NN NN NN NN');	// Code Local toujours null
		try {
			$this->assertEquals($entity,$entity->setNumber('0164337770'));
		} catch (PhoneException $e) {
			// Format non respecté
			$exception = true;
		}
		if (!$exception)
			$this->fail('Une exception attendue n\'a pas été levée');
		
		$exception = false;
		$entity->getRule()->setCode(33);
		$entity->getRule()->setLocalCode(0);
		try {
			$this->assertEquals($entity,$entity->setNumber('016433777'));
		} catch (PhoneException $e) {
			// Format non respecté
			$exception = true;
		}
		if (!$exception)
			$this->fail('Une exception attendue n\'a pas été levée');

		$tests = array(
			'0164337770'=>'1 64 33 77 70',
			'  0.164.33-7/7 70'=>'1 64 33 77 70',
			'  0,,,.16 ..    4.3 3,-,,////,7/7   7,,,0   '=>'1 64 33 77 70'
		);
		
		foreach ($tests as $in => $out)
		{
			try {
				$this->assertEquals($entity,$entity->setNumber('0164337770'));
			} catch (PhoneException $e) {
				$this->fail('Une exception non attendue a été levée');
			}
			$this->assertEquals('0'.$out,$entity->getNumber());
			$this->assertInternalType('string',$entity->getNumber());
			$this->assertEquals('+33'.$out,$entity->getNumber(true));
			$this->assertInternalType('string',$entity->getNumber(true));
		}
		$entity->getRule()->setFormat('IN.NN.NN.NN.NN');
		$this->assertEquals('01.64.33.77.70',$entity->getNumber());
		
	}
}