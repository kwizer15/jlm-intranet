<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Email;
use JLM\ContactBundle\Entity\EmailException;

class EmailTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->entity = new Email;
	}
	
	public function providerAddress()
	{
		return array(
			array('kwiZer15@WANADOO.fr','kwizer15@wanadoo.fr'),
			array('emmanuel.bernaszuk@kw12er.com','emmanuel.bernaszuk@kw12er.com'),
			array('  emmanuel.bernaszuk@kw12er.com   ','emmanuel.bernaszuk@kw12er.com'),		
		);
	}
	
	public function providerAddressException()
	{
		return array(
				array('salut'),
				array('emmanuel bernaszuk@kw12er.com'),
				array('émmanuel.bernaszuk@kw12er.com'),
				array('kwizer15@hotmail;com'),
				array('kwizer 15@hotmail.com'),
					
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerAddress
	 */
	public function testSetAddress($in)
	{
		$this->assertEquals($this->entity,$this->entity->setAddress($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerAddressException
	 * @expectedException JLM\ContactBundle\Entity\EmailException
	 */
	public function testSetAddressException($in)
	{
		$this->entity->setAddress($in);
	}
	
	/**
	 * @test
	 * @depends testSetAddress
	 * @dataProvider providerAddress
	 */
	public function testGetAddress($in,$out)
	{
		$this->entity->setAddress($in);
		$this->assertEquals($out,$this->entity->getAddress());
	}
	
	/**
	 * @test
	 * @depends testSetAddress
	 * @dataProvider providerAddress
	 */
	public function test__toString($in,$out)
	{
		$this->entity->setAddress($in);
		$this->assertEquals($out,(string)$this->entity);
	}
	
}