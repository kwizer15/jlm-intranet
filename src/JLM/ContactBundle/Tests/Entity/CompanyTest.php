<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Company;

class CompanyTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->entity = new Company;
	}
	
	public function providerName()
	{
		return array(
			array('R.I.V.P','R.I.V.P'),
			array('Touchet-Gestion','Touchet-Gestion'),
			array('JLM Entreprise','JLM Entreprise'),
			array('Aufédis','Aufédis'),
			array('1and1','1and1'),
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
	 * @dataProvider providerName
	 * @depends testSetName
	 */
	public function testGetName($in,$out)
	{
		$this->entity->setName($in);
		$this->assertSame($out,$this->entity->getName());
	}
	
	public function providerSiret()
	{
		return array(
				array('452 454 522 00016',  '45245452200016'),
				array('85132154100025   ',     '85132154100025'),
				array('  43-63-21-35-7 43421','43632135743421'),
				array('00000000000000',     '00000000000000'),
				array(45312584565452,'45312584565452'),
				array('',''),	// Inconnu
		);
	}
	
	public function providerSiretException()
	{
		return array(
				array('4524545220001'), // 13 caractères
				array('851321541000251'), // 15 caractères
				array('0000000000000a'), // pas décimal
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerSiret
	 */
	public function testSetSiret($in)
	{
		$this->assertSame($this->entity,$this->entity->setSiret($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerSiret
	 * @depends testSetSiret
	 */
	public function testGetSiret($in,$out)
	{
		$this->entity->setSiret($in);
		$this->assertSame($out,$this->entity->getSiret());
	}
	
	/**
	 * @test
	 * @dataProvider providerSiretException
	 * @depends testSetSiret
	 * @expectedException JLM\ContactBundle\Entity\CompanyException
	 */
	public function testSetSiretException($in)
	{
		$this->entity->setSiret($in);
	}
	
	public function providerSiren()
	{
		return array(
				array('452 454 522',  '452454522'),
				array('851321541',     '851321541'),
				array('  43-63-21-35-7 ','436321357'),
				array('000000000',     '000000000'),
				array(453125852,'453125852'),
				array('',''),	// Inconnu
		);
	}
	
	public function providerSirenException()
	{
		return array(
				array('45245452'), // 8 caractères
				array('8513215411'), // 10 caractères
				array('00000000a'), // pas décimal
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerSiren
	 */
	public function testSetSiren($in)
	{
		$this->assertSame($this->entity,$this->entity->setSiren($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerSiren
	 * @depends testSetSiren
	 */
	public function testGetSiren($in,$out)
	{
		$this->entity->setSiren($in);
		$this->assertSame($out,$this->entity->getSiren());
	}
	
	/**
	 * @test
	 * @dataProvider providerSiretException
	 * @depends testSetSiren
	 * @expectedException JLM\ContactBundle\Entity\CompanyException
	 */
	public function testSetSirenException($in)
	{
		$this->entity->setSiren($in);
	}
	
	public function providerNic()
	{
		return array(
				array('452 45',  '45245'),
				array('85132',     '85132'),
				array('  43-63-2 ','43632'),
				array('00000',     '00000'),
				array(45312,'45312'),
				array('',''),	// Inconnu
		);
	}
	
	public function providerNicException()
	{
		return array(
				array('4524'), // 4 caractères
				array('851321'), // 6 caractères
				array('0000a'), // pas décimal
		);
	}
	
	/**
	 * @test
	 * @dataProvider providerNic
	 */
	public function testSetNic($in)
	{
		$this->assertSame($this->entity,$this->entity->setNic($in));
	}
	
	/**
	 * @test
	 * @dataProvider providerNic
	 * @depends testSetNic
	 */
	public function testGetNic($in,$out)
	{
		$this->entity->setNic($in);
		$this->assertSame($out,$this->entity->getNic());
	}
	
	/**
	 * @test
	 * @dataProvider providerNicException
	 * @depends testSetNic
	 * @expectedException JLM\ContactBundle\Entity\CompanyException
	 */
	public function testSetNicException($in)
	{
		$this->entity->setNic($in);
	}
}