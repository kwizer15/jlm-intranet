<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Entity\PersonException;

class PersonTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->entity = new Person;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
	}
	
	public function providerTitle()
	{
		return array(
				array('M.','M.'),
				array('Mlle','Mlle'),
				array('Mme','Mme'),
				array('m.','M.'),
				array('MLLE','Mlle'),
				array('mMe','Mme'),
				
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerTitle
	 */
	public function testSetTitle($in)
	{
		$this->assertEquals($this->entity,$this->entity->setTitle($in));
	}
	
	/**
	 * @test
	 * @expectedException JLM\ContactBundle\Entity\PersonException
	 */
	public function testSetTitleBadValue()
	{
		$this->entity->setTitle('foo');
	}
	
	/**
	 * @test
	 * @dataProvider providerTitle
	 * @depends testSetTitle
	 */
	public function testGetTitle($in,$out)
	{
		$this->entity->setTitle($in);
		$this->assertEquals($out,$this->entity->getTitle($in));
	}
	
	public function providerNames()
	{
		return array(
				array('A','A'),
				array('e','E'),
				array('   Martinez ','Martinez'),
				array('de   la     motte','De La Motte'),
				array('jeAN-lOuIs','Jean-Louis'),
				array('frANçoiS   -  piERRe','François-Pierre'),
				array('','')
				
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerNames
	 */
	public function testSetFirstName($in)
	{
		$this->assertSame($this->entity,$this->entity->setFirstName($in));
	}
	
	/**
	 * @test
	 * @depends testSetFirstName
	 * @dataProvider providerNames
	 */
	public function testGetFirstName($in,$out)
	{
		$this->entity->setFirstName($in);
		$this->assertSame($out,$this->entity->getFirstName());
	}
	
	/**
	 * @test
	 * @expectedException JLM\ContactBundle\Entity\PersonException
	 */
	public function testSetFirstNameException()
	{
		$this->entity->setFirstName('R2D2');	
	}
	
	/**
	 * @test
	 * @dataProvider providerNames
	 */
	public function testSetLastName($in)
	{
		$this->assertSame($this->entity,$this->entity->setLastName($in));
	}
	
	/**
	 * @test
	 * @depends testSetLastName
	 * @dataProvider providerNames
	 */
	public function testGetLastName($in,$out)
	{
		$this->entity->setLastName($in);
		$this->assertSame($out,$this->entity->getLastName());
	}
	
	/**
	 * @test
	 * @expectedException JLM\ContactBundle\Entity\PersonException
	 */
	public function testSetLastNameException()
	{
		$this->entity->setLastName('R2D2');	
	}
	
	public function provider__toString()
	{
		return array(
				array('M.','Jean-Louis','Martinez','M. Jean-Louis MARTINEZ'),
				array('Mme','nadine','martinez','Mme Nadine MARTINEZ'),
				array('mlle','AURÉLIE','COSTALAT','Mlle Aurélie COSTALAT'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider provider__toString
	 * @depends testSetTitle
	 * @depends testSetFirstName
	 * @depends testSetLastName
	 */
	public function test__toString($title, $firstName, $lastName, $out)
	{	
		$this->entity->setTitle($title);
		$this->entity->setFirstName($firstName);
		$this->entity->setLastName($lastName);
		$this->assertSame($out,$this->entity->__toString());
	}
}