<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactData;
use JLM\ContactBundle\Entity\ContactDataException;

class ContactDataTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\ContactData');
		
		$this->contact = $this->getMock('JLM\ContactBundle\Model\ContactInterface');
	}
	
	public function providerAlias()
	{
		return array(
			array('Pro','Pro'),
			array('perso','Perso'),
			array('1er Secrétariat','1er secrétariat'),
			array('  n\'importe-quoi  encore  ','N\'importe-quoi encore'),
			array('une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données ggggggg',
					  'Une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données g'),
			array(12,'12'),
			array(true,'1'),
		);
	}
	
	public function providerAliasException()
	{
		return array(
				array(''),
				array(false),
				array(array()),
				array(new \stdClass),
		);
	}
	
	/**
	 * @test
	 */
	public function testInitialAlias()
	{
		$this->assertSame('',$this->entity->getAlias());
	} 
	
	/**
	 * @test
	 * @dataProvider providerAlias
	 */
	public function testSetAlias($in)
	{
		$this->assertEquals($this->entity,$this->entity->setAlias($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerAliasException
	 * @expectedException JLM\ContactBundle\Entity\ContactDataException
	 */
	public function testSetAliasException($in)
	{
		$this->entity->setAlias($in);
	}
	
	/**
	 * @test
	 * @dataProvider providerAlias
	 * @depends testSetAlias
	 */
	public function testGetAlias($in,$out)
	{
		$this->entity->setAlias($in);
		$this->assertSame($out,$this->entity->getAlias());
	}
	
	/**
	 * @test
	 */
	public function testSetContact()
	{
		$this->assertSame($this->entity, $this->entity->setContact($this->contact));
	}
	
	/**
	 * @test
	 * @depends testSetContact
	 */
	public function testGetContact()
	{
		$this->entity->setContact($this->contact);
		$this->assertSame($this->contact, $this->entity->getContact());
	}
	
}