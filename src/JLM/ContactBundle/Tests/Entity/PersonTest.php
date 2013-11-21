<?php
namespace JLM\ContactBundle\Tests\Entity;

use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Entity\PersonException;

class PersonTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function testTitle()
	{
		$entity = new Person;
		$this->assertEmpty($entity->getTitle());
		
		$this->assertEquals($entity,$entity->setTitle('M.'));
		$this->assertEquals('M.',$entity->getTitle());
		$this->assertEquals($entity,$entity->setTitle('Mme'));
		$this->assertEquals('Mme',$entity->getTitle());
		$this->assertEquals($entity,$entity->setTitle('Mlle'));
		$this->assertEquals('Mlle',$entity->getTitle());
		$this->assertEquals($entity,$entity->setTitle(''));
		$this->assertEmpty($entity->getTitle());
		
		// Filtre
		$this->assertEquals($entity,$entity->setTitle('m.'));
		$this->assertEquals('M.',$entity->getTitle());
		$this->assertEquals($entity,$entity->setTitle('MME'));
		$this->assertEquals('Mme',$entity->getTitle());
		$this->assertEquals($entity,$entity->setTitle('mLLe'));
		$this->assertEquals('Mlle',$entity->getTitle());
		
		// Exceptions
		try { $this->assertEquals($entity,$entity->setTitle('monsieur')); }
		catch (PersonException $e) { $exception = true; }
		if (!$exception) { $this->fail('Une exception attendue n\'a pas été levée'); }
		
		try { $this->assertEquals($entity,$entity->setTitle('m')); }
		catch (PersonException $e) { $exception = true; }
		if (!$exception) { $this->fail('Une exception attendue n\'a pas été levée'); }
		
		try { $this->assertEquals($entity,$entity->setTitle('n\'importe quoi d\'autre')); }
		catch (PersonException $e) { $exception = true; }
		if (!$exception) { $this->fail('Une exception attendue n\'a pas été levée'); }
	}
	
	/**
	 * @test
	 */
	public function testFirstName()
	{
		$entity = new Person;
		$this->assertEmpty($entity->getFirstName());
		
		$this->assertEquals($entity,$entity->setFirstName('A'));
		$this->assertEquals('A',$entity->getFirstName());
		$this->assertEquals($entity,$entity->setFirstName('e'));
		$this->assertEquals('E',$entity->getFirstName());
		$this->assertEquals($entity,$entity->setFirstName('   Martinez '));
		$this->assertEquals('Martinez',$entity->getFirstName());
		$this->assertEquals($entity,$entity->setFirstName('de   la     motte'));
		$this->assertEquals('De La Motte',$entity->getFirstName());
		$this->assertEquals($entity,$entity->setFirstName('jeAN-lOuIs'));
		$this->assertEquals('Jean-Louis',$entity->getFirstName());
		$this->assertEquals($entity,$entity->setFirstName('frANçoiS   -  piERRe'));
		$this->assertEquals('François-Pierre',$entity->getFirstName());
		$this->assertEquals($entity,$entity->setFirstName(''));
		$this->assertEmpty($entity->getFirstName());
			
		try { $this->assertEquals($entity,$entity->setFirstName('R2D2')); }
		catch (PersonException $e) { $exception = true; }
		if (!$exception) { $this->fail('Une exception attendue n\'a pas été levée'); }
		
	}
	
	/**
	 * @test
	 */
	public function testLastName()
	{
		$entity = new Person;
		$this->assertEmpty($entity->getLastName());
		
		$this->assertEquals($entity,$entity->setLastName('A'));
		$this->assertEquals('A',$entity->getLastName());
		$this->assertEquals($entity,$entity->setLastName('e'));
		$this->assertEquals('E',$entity->getLastName());
		$this->assertEquals($entity,$entity->setLastName('  Martinez   '));
		$this->assertEquals('Martinez',$entity->getLastName());
		$this->assertEquals($entity,$entity->setLastName('de   la    motte'));
		$this->assertEquals('De La Motte',$entity->getLastName());
		$this->assertEquals($entity,$entity->setLastName('jeAN  -   lOuIs'));
		$this->assertEquals('Jean-Louis',$entity->getLastName());
		$this->assertEquals($entity,$entity->setLastName('frANçoiS-piERRe'));
		$this->assertEquals('François-Pierre',$entity->getLastName());
		$this->assertEquals($entity,$entity->setLastName(''));
		$this->assertEmpty($entity->getLastName());
		
		try { $this->assertEquals($entity,$entity->setLastName('R2D2')); }
		catch (PersonException $e) { $exception = true; }
		if (!$exception) { $this->fail('Une exception attendue n\'a pas été levée'); }
	}
	
	/**
	 * @test
	 */
	public function test__toString()
	{
		$entity = new Person;
		
		$entity->setTitle('M.');
		$entity->setFirstName('Jean-Louis');
		$entity->setLastName('Martinez');
		$this->assertEquals('M. Jean-Louis MARTINEZ',(string)$entity);
	}
}