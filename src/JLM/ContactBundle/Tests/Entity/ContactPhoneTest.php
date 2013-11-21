<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Entity\Phone;

class ContactPhoneTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testAlias()
	{
		$entity = new ContactPhone;
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
				array(''),
				array(12),
				array(true),
				array(false),
	
		);
		foreach ($tests as $test)
		{
			try {
				$this->assertEquals($entity,$entity->setAlias($test[0]));
			} catch (\Exception $e) {
				if (isset($test[1]))
					$this->fail('Une exception non attendue a été levée');
				continue;
			}
			if (!isset($test[1]))
			{
				$this->fail('Une exception attendue n\'a pas été levée');
				continue;
			}
			$this->assertEquals($test[1],$entity->getAlias());
			$this->assertInternalType('string',$entity->getAlias());
		}
	
	}
}