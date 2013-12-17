<?php
namespace JLM\ContactBundle\Tests\Form;

use Symfony\Component\Form\Test\TypeTestCase;

use JLM\ContactBundle\Form\Type\AddressType;
use JLM\ContactBundle\Entity\Address;
use JLM\ContactBundle\Entity\City;
use JLM\ContactBundle\Entity\Country;

class AddressTypeTest extends TypeTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->form = $this->factory->create(new AddressType);
		$city = new City('Saint-Soupplets', '77165', new Country('FR','France'));
	}
	
	public function validData()
	{
		return array(
				array('17, avenue de Montboulon', new City('Saint-Soupplets', '77165', new Country('FR','France'))),
		);
	}
	
	/**
	 * @dataProvider validData
	 */
	public function testSubmitValidData($street, $city)
	{
		$formData = array(
				'street' => $street,
				'city' => $city,
		);
	
		$object = new Address($street,$city);
		
		// submit the data to the form directly
		$this->form->submit($formData);
		
		$this->assertTrue($this->form->isSynchronized());
		$this->assertEquals($object, $this->form->getData());
		
		
		$view = $this->form->createView();
		$children = $view->children;
		
		foreach (array_keys($formData) as $key) {
			$this->assertArrayHasKey($key, $children);
		}
	}
}