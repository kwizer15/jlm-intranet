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
		
		$this->assertCount(0,$entity->getAddresses());
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
		$this->assertEquals($entity,$entity->removeAddress($address3));
		$this->assertCount(2,$entity->getAddresses());
		$exception = false;
		try {
			$this->assertEquals($entity,$entity->addAddress('salut'));
		} catch (\Exception $e) {
			$exception = true;
		}
		if (!$exception)
			$this->fail('Une exception attendue n\'a pas été levée');
		$this->assertCount(2,$entity->getAddresses());
	}
	
	/**
	 * @test
	 */
	public function testPhones()
	{
		$entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\Contact');
		
		$phone1 = new ContactPhone;
		$phone2 = new ContactPhone;
		$phone3 = new ContactPhone;
		
		$this->assertCount(0,$entity->getPhones());
		$this->assertEquals($entity,$entity->addPhone($phone1));
		$this->assertCount(1,$entity->getPhones());
		$this->assertEquals($entity,$entity->addPhone($phone2));
		$this->assertCount(2,$entity->getPhones());
		$this->assertEquals($entity,$entity->addPhone($phone3));
		$this->assertCount(3,$entity->getPhones());
		$this->assertEquals($entity,$entity->removePhone($phone1));
		$this->assertCount(2,$entity->getPhones());
		$this->assertEquals($entity,$entity->removePhone($phone1));	// On retire un élement non présent
		$this->assertCount(2,$entity->getPhones());
		$this->assertEquals($entity,$entity->addPhone($phone3));
		$this->assertCount(3,$entity->getPhones());
		$this->assertEquals($entity,$entity->removePhone($phone3));
		$this->assertCount(2,$entity->getPhones());
		$exception = false;
		try {
			$this->assertEquals($entity,$entity->addPhone('salut'));
		} catch (\Exception $e) {
			$exception = true;
		}
		if (!$exception)
			$this->fail('Une exception attendue n\'a pas été levée');
		$this->assertCount(2,$entity->getPhones());
	}
	
	/**
	 * @test
	 */
	public function testEmails()
	{
		$entity = $this->getMockForAbstractClass('JLM\ContactBundle\Entity\Contact');
		
		$email1 = new ContactEmail;
		$email2 = new ContactEmail;
		$email3 = new ContactEmail;
		
		$this->assertCount(0,$entity->getEmails());
		$this->assertEquals($entity,$entity->addEmail($email1));
		$this->assertCount(1,$entity->getEmails());
		$this->assertEquals($entity,$entity->addEmail($email2));
		$this->assertCount(2,$entity->getEmails());
		$this->assertEquals($entity,$entity->addEmail($email3));
		$this->assertCount(3,$entity->getEmails());
		$this->assertEquals($entity,$entity->removeEmail($email1));
		$this->assertCount(2,$entity->getEmails());
		$this->assertEquals($entity,$entity->removeEmail($email1));	// On retire un élement non présent
		$this->assertCount(2,$entity->getEmails());
		$this->assertEquals($entity,$entity->addEmail($email3));
		$this->assertCount(3,$entity->getEmails());
		$this->assertEquals($entity,$entity->removeEmail($email3));
		$this->assertCount(2,$entity->getEmails());
		$exception = false;
		try {
			$this->assertEquals($entity,$entity->addEmail('salut'));
		} catch (\Exception $e) {
			$exception = true;
		}
		if (!$exception)
			$this->fail('Une exception attendue n\'a pas été levée');
		$this->assertCount(2,$entity->getEmails());
	}
}