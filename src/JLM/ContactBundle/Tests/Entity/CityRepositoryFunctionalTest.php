<?php
namespace JLM\ContactBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CityRepositoryFunctionalTest extends WebTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * @{inheritdoc}
	 */
	public function setUp()
	{
		static::$kernel = static::createKernel();
		static::$kernel->boot();
		$this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
	}
	
	/**
	 * @test
	 */
	public function testSearchByCityName()
	{
		$cities = $this->em
			->getRepository('JLMContactBundle:City')
			->searchResult('othis')
		;
	
		$this->assertCount(1, $cities);
	}
	
	/**
	 * @test
	 */
	public function testSearchByCityZip()
	{
		$cities = $this->em
		->getRepository('JLMContactBundle:City')
		->searchResult('77280')
		;
	
		$this->assertCount(1, $cities);
	}
}