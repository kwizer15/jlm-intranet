<?php
namespace JLM\ContactBundle\Tests\Form;

use JLM\ContactBundle\Entity\Phone;
use JLM\ContactBundle\Entity\PhoneRule;
use JLM\ContactBundle\Entity\Country;
use JLM\ContactBundle\Form\Type\PhoneType;
use Symfony\Component\Form\Test\TypeTestCase;

class PhoneTypeTest extends TypeTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->rule = new PhoneRule('IN NN NN NN NN',33,0,new Country('FR','France'));
		$this->form = $this->factory->create(new PhoneType($this->rule));
		
	}
	
	public function validData()
	{
		return array(
				array('0160030687'),
				array('0619379665'),
		);
	}
	
	/**
	 * @dataProvider validData
	 */
	public function testSubmitValidData($number)
	{
		$formData = array(
				'number' => $number,
		);
	
		$object = new Phone($this->rule,$number);
		
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