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
	public function testAlias()
	{
		$entity = new Phone;
		$this->assertEquals('',$entity->getAlias());
		$this->assertInternalType('string',$entity->getAlias());
		
		$tests = array(
			array('Téléphone','Téléphone'),
				array('bureau','Bureau'),
				array('fAx','Fax'),
				array('1er Secrétariat','1er secrétariat'),
				array('  n\'importe-quoi  encore  ','N\'importe-quoi encore'),
				array('une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données ggggggg',
					  'Une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données g'),
				array('',null),
				array(12,null),
				array(true,null),
				array(false,null),
				
		);
		foreach ($tests as $test)
		{
			try {
				$this->assertEquals($entity,$entity->setAlias($test[0]));
			} catch (PhoneException $e) {
				if ($test[1] !== null)
					$this->fail('Une exception non attendue a été levée');
				continue;
			}
			if ($test[1] === null)
			{
				$this->fail('Une exception attendue n\'a pas été levée');
				continue;
			}
			$this->assertEquals($test[1],$entity->getAlias());
			$this->assertInternalType('string',$entity->getAlias());
		}
		
	}
	
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
			array(true,null),
			array('INNNNN',null),
			array(1,null),
		);
		
		foreach ($tests as $test)
		{
			try {
				$this->assertEquals($entity,$entity->setRule($test[0]));
			} catch (\Exception $e) {
				if ($test[1] !== null)
					$this->fail('Une exception non attendue a été levée.');
				continue;
			}
			if ($test[1] === null)
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