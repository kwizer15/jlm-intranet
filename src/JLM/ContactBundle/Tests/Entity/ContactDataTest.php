<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactData;
use JLM\ContactBundle\Entity\ContactDataException;

class ContactDataTest extends \PHPUnit_Framework_TestCase
{
	public function providerAlias()
	{
		return array(
			array('Pro','Pro'),
			array('perso','Perso'),
			array('1er Secrétariat','1er secrétariat'),
			array('  n\'importe-quoi  encore  ','N\'importe-quoi encore'),
			array('une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données ggggggg',
					  'Une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données une chaine de caractère super longue qui doit faire au moins 255 caractères pour que ca bug au niveau de la base de données g'),
			array(''),
			array(12,'12'),
			array(true,'1'),
			array(false),
			array(array()),
			array(new \stdClass),
	
		);
	}
	
	public function testInitialAlias()
	{
		$entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\ContactData');
		$this->assertSame('',$entity->getAlias());
	} 
	
	/**
	 * @test
	 * @dataProvider providerAlias
	 */
	public function testAlias($in,$out = 'Exception')
	{
		$entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\ContactData');

		try {
			$this->assertEquals($entity,$entity->setAlias($in));
			if ($out === 'Exception')
				$this->fail('Une exception attendue n\'a pas été levée');
			else
				$this->assertSame($out,$entity->getAlias());
		} catch (ContactDataException $e) {
			if ($out !== 'Exception')
				$this->fail('Une exception non attendue a été levée');
		}	
	}
}