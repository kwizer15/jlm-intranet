<?php
namespace JLM\ModelBundle\Tests\Entity;

use JLM\ModelBundle\Entity\Country;
use JLM\ModelBundle\Entity\CountryException;

class CountryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testCode()
	{
		$entity = new Country;
		$this->assertNull($entity->getCode());
		$tests = array(
				' france'=>'FR',
				'bElGiQuE'=>'BE',
				'LU'=>'LU',
				'2  '=>null,
				'M'=>null,
				'an?g4ds52'=>'AN',
				'n*ull'=>null,
				'    12er1qs   '=>null,
				'e2e'=>null,
		);
		foreach ($tests as $in => $out)
		{
			try {
				$this->assertEquals($entity,$entity->setCode($in));	
			}
			catch (CountryException $e)
			{
				if ($out !== null)
					$this->fail('Une exception non attendue a été levée.');
				continue;
			}
					
			if ($out === null)
				$this->fail('Une exception attendue n\'a pas été levée : '.$in);
			else {
				$this->assertEquals($out,$entity->getCode());
				$this->assertInternalType('string',$entity->getCode());
			}
				
		}
		
		// Test avec un objet
		try {
			$this->assertEquals($entity,$entity->setCode($entity));
		}
		catch (CountryException $e)
		{
			if ($out !== null)
				$this->fail('Une exception non attendue a été levée.');
		}
	}
	
	/**
	 * @test
	 */
	public function testName()
	{
		$entity = new Country;
		$this->assertEquals('',$entity->getName());
		$this->assertInternalType('string',$entity->getName());
		
		$tests = array('france'=>'France','bElGiQuE'=>'Belgique','LU'=>'Lu','2'=>'','M'=>'M','n'=>'N');
		foreach ($tests as $in => $out)
		{
			$this->assertEquals($entity,$entity->setName($in));
			$this->assertEquals($out,$entity->getName());
			$this->assertInternalType('string',$entity->getName());
		}
	}



}