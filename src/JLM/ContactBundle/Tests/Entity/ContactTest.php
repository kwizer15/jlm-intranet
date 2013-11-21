<?php
namespace JLM\ContactBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use JLM\ContactBundle\Entity\ContactAddress;
use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Entity\ContactEmail;

class ContactTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testAddresses()
	{
		$entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\Contact');
		$address1 = new ContactAddress;
		$address2 = new ContactAddress;
		$address3 = new ContactAddress;
		
		$this->assertEquals(new ArrayCollection,$entity->getAddresses());
		$this->assertEquals($entity,$entity->addAddress($address1));
		$this->assertCount(1,$entity->getAddresses());
		$this->assertEquals($entity,$entity->addAddress($address2));
		$this->assertCount(2,$entity->getAddresses());
		$this->assertEquals($entity,$entity->addAddress($address3));
		$this->assertCount(3,$entity->getAddresses());
		$this->assertEquals($entity,$entity->removeAddress($address1));
		$this->assertCount(2,$entity->getAddresses());
		$this->assertEquals($entity,$entity->removeAddress($address1));	// On retire un élement non présent
		$this->assertCount(2,$entity->getAddresses());
		$this->assertEquals($entity,$entity->addAddress($address3));
		$this->assertCount(3,$entity->getAddresses());
		$exception = false;
		try {
			$this->assertEquals($entity,$entity->addAddress('salut'));
		} catch (\Exception $e) {
			$exception = true;
		}
		if (!$exception)
			$this->fail('Une exception attendue n\'a pas été levée');
		$this->assertCount(3,$entity->getAddresses());
	}
	
	/**
	 * @test
	 */
	public function testPhones()
	{
		$entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\Contact');
		
		$this->assertEquals(new ArrayCollection,$entity->getPhones());
	}
	
	/**
	 * @test
	 */
	public function testEmails()
	{
		$entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\Contact');
		
		$this->assertEquals(new ArrayCollection,$entity->getEmails());
	}
}