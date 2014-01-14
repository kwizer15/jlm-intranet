<?php
namespace JLM\ModelBundle\Tests\Entity;

use JLM\ModelBundle\Entity\Door;

use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\DoorType;
use JLM\ModelBundle\Entity\Contract;

class DoorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * {@inheritdoc}
	 */
	protected function setUp()
	{
		$this->entity = new Door;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function assertPreConditions()
	{
		$this->assertNull($this->entity->getId());
		$this->assertNull($this->entity->getActualContract());
		$this->assertCount(0,$this->entity->getContracts());
		$this->assertCount(0,$this->entity->getInterventions());
	}
	
	public function testSetSite()
	{
		$this->assertSame($this->entity, $this->entity->setSite(new Site));
	}
	
	public function testGetSite()
	{
		$site = new Site;
		$this->entity->setSite($site);
		$this->assertSame($site, $this->entity->getSite());
	}
	
	/**
	 * Provider for streets test
	 * @return array
	 */
	public function dataStreet()
	{
		return array(
				array('6, rue du truc bidule chouette'),
				array('25, avenue des fonds publics'),
				array('6, boulevard des Capucines'),
				array('place Moreau'),
				array('pas d\'adresse !!!'),
		);
	}
	
	/**
	 * @param string $street
	 * @dataProvider dataStreet
	 */	
	public function testSetStreet($street)
	{
		$this->assertSame($this->entity, $this->entity->setStreet($street));
	}
	
	/**
	 * @param string $street
	 * @dataProvider dataStreet
	 */
	public function testGetStreet($street)
	{
		$this->entity->setStreet($street);
		$this->assertSame($street,$this->entity->getStreet());
	}
	
	/**
	 * Provider for locations test
	 * @return array
	 */
	public function dataLocation()
	{
		return array(
				array('Façade'),
				array('Sous-sol'),
		);
	}
	
	/**
	 * @param string $location
	 * @dataProvider dataLocation
	 */
	public function testSetLocation($location)
	{
		$this->assertSame($this->entity, $this->entity->setLocation($location));
	}
	
	/**
	 * @param string $location
	 * @dataProvider dataLocation
	 */
	public function testGetLocation($location)
	{
		$this->entity->setLocation($location);
		$this->assertSame($location,$this->entity->getLocation());
	}
	
	/**
	 * Provider for observations test
	 * @return array
	 */
	public function dataObservations()
	{
		return array(
				array('Code portilon : 25142'),
		);
	}
	
	/**
	 * @param string $observations
	 * @dataProvider dataObservations
	 */
	public function testSetObservations($observations)
	{
		$this->assertSame($this->entity, $this->entity->setObservations($observations));
	}
	
	/**
	 * @param string $observations
	 * @dataProvider dataObservations
	 */
	public function testGetObservations($observations)
	{
		$this->entity->setObservations($observations);
		$this->assertSame($observations,$this->entity->getObservations());
	}
	
	public function testSetType()
	{
		$this->assertSame($this->entity, $this->entity->setType(new DoorType));
	}
	
	public function testGetType()
	{
		$type = new DoorType();
		$this->entity->setType($type);
		$this->assertSame($type, $this->entity->getType());
	}
	
	public function testAddContract()
	{
		$this->assertSame($this->entity, $this->entity->addContract(new Contract()));
	}
	
	public function testGetContracts()
	{
		$this->entity->addContract(new Contract());
		$this->entity->addContract(new Contract());
		$this->entity->addContract(new Contract());
		$this->assertCount(3, $this->entity->getContracts());
	}
	
	public function testRemoveContract()
	{
		$contract = new Contract();
		$this->entity->addContract(new Contract());
		$this->entity->addContract($contract);
		$this->entity->addContract(new Contract());
		$this->entity->removeContract($contract);
		$this->assertCount(2, $this->entity->getContracts());
	}
	
	public function testAddIntervention()
	{
		$this->assertSame($this->entity, $this->entity->addIntervention($this->getMock('JLM\DailyBundle\Entity\Intervention')));
	}
	
	public function testGetInterventions()
	{
		$this->entity->addIntervention($this->getMock('JLM\DailyBundle\Entity\Intervention'));
		$this->entity->addIntervention($this->getMock('JLM\DailyBundle\Entity\Intervention'));
		$this->entity->addIntervention($this->getMock('JLM\DailyBundle\Entity\Intervention'));
		$this->assertCount(3, $this->entity->getInterventions());
	}
	
	public function testRemoveIntervention()
	{
		$intervention = $this->getMock('JLM\DailyBundle\Entity\Intervention');
		$this->entity->addIntervention($this->getMock('JLM\DailyBundle\Entity\Intervention'));
		$this->entity->addIntervention($intervention);
		$this->entity->addIntervention($this->getMock('JLM\DailyBundle\Entity\Intervention'));
		$this->entity->removeIntervention($intervention);
		$this->assertCount(2, $this->entity->getInterventions());
	}
	
	public function testGetTrustee()
	{
		$contractTrustee = $this->getMock('JLM\ModelBundle\Entity\Trustee');
		$contract = new Contract();
		$contract->setTrustee($contractTrustee);
		$siteTrustee = $this->getMock('JLM\ModelBundle\Entity\Trustee');
		$site = new Site;
		$site->setTrustee($siteTrustee);
		$this->entity->setSite($site);
		$this->assertSame($siteTrustee, $this->entity->getTrustee());
		$this->entity->addContract($contract);
		$this->assertSame($contractTrustee, $this->entity->getTrustee());
	}
}