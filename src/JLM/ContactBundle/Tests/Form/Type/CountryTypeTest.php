<?php
namespace JLM\ContactBundle\Tests\Form;

use JLM\ContactBundle\Entity\Country;
use JLM\ContactBundle\Form\Type\CountryType;
use Symfony\Component\Form\Test\TypeTestCase;

class CountryTypeTest extends TypeTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->form = $this->factory->create(new CountryType);
	}
	
	public function validData()
	{
		return array(
				array('FR','France'),
				array('GBT','Great Britain'),
		);
	}
	
	/**
	 * @dataProvider validData
	 */
	public function testSubmitValidData($code,$name)
	{
		$formData = array(
				'code' => $code,
				'name' => $name,
		);
	
		$object = new Country($code,$name);
		
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