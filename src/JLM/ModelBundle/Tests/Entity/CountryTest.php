<?php
namespace JLM\ModelBundle\Tests\Entity;

use JLM\ModelBundle\Entity\Country;

class CountryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testCode()
	{
		$entity = new Country;
		$this->assertNull($entity->getCode());
		$tests = array('france'=>'FR','bElGiQuE'=>'BE','LU'=>'LU','2'=>null,'M'=>null);
		foreach ($tests as $in => $out)
		{
			$this->assertEquals($entity,$entity->setCode($in));
			$this->assertEquals($out,$entity->getCode());
			if (($entity->getCode() !== null))
				$this->assertInternalType('string',$entity->getCode());
		}
	}
	
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