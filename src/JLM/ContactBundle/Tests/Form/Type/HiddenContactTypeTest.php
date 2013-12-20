<?php
namespace JLM\ContactBundle\Tests\Form;

use JLM\ContactBundle\Entity\Contact;
use JLM\ContactBundle\Form\Type\HiddenContactType;
use Symfony\Component\Form\Test\TypeTestCase;

class HiddenContactTypeTest extends TypeTestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		parent::setUp();
		$om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
		$this->form = $this->factory->create(new HiddenContactType($om));
		
	}
	
	public function testALaCon()
	{
		$this->assertEquals(true,true);
	}
	
	
//	public function validData()
//	{
//		return array(
//				array('emmanuel.bernaszuk@jlm-entreprise.fr'),
//		);
//	}
//	
//	/**
//	 * @dataProvider validData
//	 */
//	public function testSubmitValidData($email)
//	{
//		$formData = array(
//				'address' => $email,
//		);
//	
//		$object = new Email($email);
//		
//		// submit the data to the form directly
//		$this->form->submit($formData);
//		
//		$this->assertTrue($this->form->isSynchronized());
//		$this->assertEquals($object, $this->form->getData());
//		
//		
//		$view = $this->form->createView();
//		$children = $view->children;
//		
//		foreach (array_keys($formData) as $key) {
//			$this->assertArrayHasKey($key, $children);
//		}
//	}
}