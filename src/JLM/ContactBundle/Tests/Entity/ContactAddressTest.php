<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactAddress;
use JLM\ContactBundle\Entity\Address;

class ContactAddressTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		$this->address = $address = $this->getMock('JLM\ContactBundle\Model\AddressInterface');
		$this->address->expects($this->any())
			    ->method('__toString')
			    ->will($this->returnValue('17, avenue de Montboulon'.chr(10).'77165 - Saint-Soupplets'));
		$this->entity = new ContactAddress($this->address);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
	}
	
	public function booleans()
	{
		return array(
			array(false,false),
			array(true,true),
			array(null,false),
			array(1,true),
			array(0,false),
			array('1',true),
			array('0',false),
			array('foo',true),
		);
	}
	
	/**
	 * @test
	 * @dataProvider booleans
	 */
	public function testSetMain($in, $out)
	{
		$this->assertSame($this->entity,$this->entity->setMain($in));
	}
	
	/**
	 * @test
	 * @depends testSetMain
	 * @dataProvider booleans
	 */
	public function testGetMain($in, $out)
	{
		$this->entity->setMain($in);
		$this->assertSame($out,$this->entity->getMain());
	}
	
	/**
	 * @test
	 */
	public function testSetAddress()
	{
		$this->assertSame($this->entity,$this->entity->setAddress($this->address));
	}

	
	/**
	 * @test
	 * @depends testSetAddress
	 */
	public function testGetAddress()
	{
		$this->assertSame($this->address, $this->entity->getAddress());
	}

	/**
	 * @test
	 * @depends testSetAddress
	 */
	public function test__toString()
	{
		$this->assertSame('17, avenue de Montboulon'.chr(10).'77165 - Saint-Soupplets',$this->entity->__toString());
	}
	
	public function providerLabel()
	{
		return array(
				array('JC Decaux','JC Decaux'),
				array('Loiselet-et-Daigremont','Loiselet-et-Daigremont'),
				array('1and1','1and1'),
				array('',null),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerLabel
	 */
	public function testSetLabel($in)
	{
		$this->assertSame($this->entity, $this->entity->setLabel($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerLabel
	 * @depends testSetLabel
	 */
	public function testGetLabel($in,$out)
	{
		$this->entity->setLabel($in);
		$this->assertSame($out, $this->entity->getLabel());
	}
}