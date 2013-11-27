<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactAddress;
use JLM\ContactBundle\Entity\Address;

class ContactAddressTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->entity = new ContactAddress;
	}
	
	/**
	 * @test
	 */
	public function testInitialGetId()
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
	public function testSetForBilling($in, $out)
	{
		$this->assertSame($this->entity,$this->entity->setForBilling($in));
	}
	
	/**
	 * @test
	 * @dataProvider booleans
	 */
	public function testSetForDelivery($in, $out)
	{
		$this->assertSame($this->entity,$this->entity->setForDelivery($in));
	
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
	 * @depends testSetForBilling
	 * @dataProvider booleans
	 */
	public function testGetForBilling($in, $out)
	{
		$this->entity->setForBilling($in);
		$this->assertSame($out,$this->entity->getForBilling());
	}
	
	/**
	 * @test
	 * @depends testSetForDelivery
	 * @dataProvider booleans
	 */
	public function testGetForDelivery($in, $out)
	{
		$this->entity->setForDelivery($in);
		$this->assertSame($out,$this->entity->getForDelivery());
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

	public function providerAddress()
	{
		return array(
				array(new Address,false),
				array('foo',true),
				array(1,true),
				array(null,true),
				array(true,true),
				array(array(),true),
				array(new \stdClass,true),
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerAddress
	 */
	public function testSetAddress($data, $exception)
	{
		try {
			$this->assertSame($this->entity,$this->entity->setAddress($data));
			if ($exception)
				$this->fail('Exception non levée');
		} catch (\Exception $e) {
			if (!$exception)
				$this->fail('Exception levée : '.$e);
		}
	}

	
	/**
	 * @test
	 * @dataProvider providerAddress
	 * @depends testSetAddress
	 */
	public function testGetAddress($data, $exception)
	{
		if (!$exception)
		{
			$this->entity->setAddress($data);
			$this->assertSame($data, $this->entity->getAddress());
		}
	}
	
	public function provider__toString()
	{
		return array(
			
				array('1, rue bidule-Truc',
						'75020',
						'Paris 20',
						'1, rue bidule-Truc'.chr(10).'75020 - Paris 20'),
		);
	}
	
	/**
	 * @test
	 * @dataProvider provider__toString
	 * @depends testSetAddress
	 */
	public function test__toString($street,$zip,$cityName,$out)
	{
		$this->entity->getAddress()->setStreet($street);
		$this->entity->getAddress()->setZip($zip);
		$this->entity->getAddress()->setCityName($cityName);
		$this->assertSame($out,$this->entity->__toString());
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