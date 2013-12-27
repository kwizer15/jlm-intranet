<?php
namespace JLM\ContactBundle\Tests\Form;

use Symfony\Component\Form\Test\TypeTestCase;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Entity\Person;

class PersonTypeTest extends TypeTestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		parent::setUp();
		$this->form = $this->factory->create(new PersonType);
	}

	public function validData()
	{
		return array(
					array(
						array(
							'title'     => 'M.',
							'firstName' => 'Emmanuel',
							'lastName'  => 'Bernaszuk',
						),
					),
					array(
						array(
							'title'     => 'Mme',
							'firstName' => 'Nadine',
							'lastName'  => 'Martinez',
						),
					),
					array(
						array(
							'title'     => 'Mlle',
							'firstName' => 'Aurélie',
							'lastName'  => 'Costalat',
						),
					),
		);
	}
	
	/**
	 * @dataProvider validData
	 */
	public function testSubmitValidData($data)
	{
		$object = new Person($data['title'],$data['firstName'],$data['lastName']);
		
		// submit the data to the form directly
		$this->form->submit($data);
		
		$this->assertTrue($this->form->isSynchronized());
		$this->assertEquals($object, $this->form->getData());
		
		
		$view = $this->form->createView();
		$children = $view->children;
		
		foreach (array_keys($data) as $key) {
			$this->assertArrayHasKey($key, $children);
		}
	}
}