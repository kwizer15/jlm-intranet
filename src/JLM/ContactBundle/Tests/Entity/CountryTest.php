<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Country;

class CountryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->entity = new Country('FR','France');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertSame('FR',$this->entity->getCode());
		$this->assertSame('France',$this->entity->getName());
	}
	
	public function providerCode()
	{
		return array(
			array(' france','FR'),
			array('bElGiQuE','BE'),
			array('LU','LU'),
			array('an?g4ds52','AN'),
		);
	}
	
	public function providerBadCode()
	{
		return array(
				array('2  '),
				array('M'),
				array('n*ull'),
				array('    12er1qs   '),
				array('e2e'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerCode
	 */
	public function testSetCode($in)
	{
		$this->assertSame($this->entity, $this->entity->setCode($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerBadCode
	 */
	public function testSetCodeWithBadParameter($in)
	{
		$this->entity->setCode($in);
		$this->assertNull($this->entity->getCode());
	}
	
	/**
	 * @test
	 * @dataProvider providerCode
	 */
	public function testGetCode($in,$out)
	{
		$this->entity->setCode($in);
		$this->assertSame($out, $this->entity->getCode());
	}
	
	public function providerName()
	{
		return array(
				array('france','France'),
				array('bElGiQuE','Belgique'),
				array('LU','Lu'),
				array('M','M'),
				array('n','N')
		);
	}
	
	public function providerBadName()
	{
		return array(
				array('2'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerName
	 */
	public function testSetName($in)
	{
		$this->assertSame($this->entity,$this->entity->setName($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerBadName
	 */
	public function testSetNameWithBadParameter($in)
	{
		$this->entity->setName($in);
		$this->assertNull($this->entity->getName());
	}
	
	/**
	 * @test
	 * @dataProvider providerName
	 * @depends testSetName
	 */
	public function testGetName($in,$out)
	{
		$this->entity->setName($in);
		$this->assertSame($out,$this->entity->getName());
	}

	/**
	 * @test
	 * @dataProvider providerName
	 * @depends testSetName
	 */
	public function test__toString($in,$out)
	{
		$this->entity->setName($in);
		$this->assertSame($out,(string)$this->entity);
	}


}