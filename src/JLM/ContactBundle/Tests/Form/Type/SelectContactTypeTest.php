<?php
namespace JLM\ContactBundle\Tests\Form;

use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\FormBuilder;

use Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2Type;
use JLM\ContactBundle\Form\Type\SelectContactType;
use Symfony\Component\Form\Test\TypeTestCase;

class SelectContactTypeTest extends TypeTestCase
{
	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		parent::setUp();
	
	
	
		$this->factory = Forms::createFormFactoryBuilder()
		->addExtensions($this->getExtensions())
		->addTypeExtension(
				new FormTypeValidatorExtension(
						$this->getMock('Symfony\Component\Validator\ValidatorInterface')
				)
		)
		->addTypeGuesser(
				$this->getMockBuilder(
						'Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser'
				)
				->disableOriginalConstructor()
				->getMock()
		)
		->getFormFactory();
	
		$this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
		$this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
	
		$om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
		$this->form = $this->factory->create(new SelectContactType($om));
	}
	
	protected function getContact()
	{
		$contact = $this->getMock('JLM\ContactBundle\Model\ContactInterface');
		$contact->expects($this->any())->method('getName')->will($this->returnValue('JLM Entreprise'));
		$contact->expects($this->any())->method('__toString')->will($this->returnValue('JLM Entreprise'));
		return $contact;
	}
	
	protected function getExtensions()
	{
		$select2Type = new Select2Type('entity');
		
		$mockEntityType = $this->getMockBuilder('Symfony\Bridge\Doctrine\Form\Type\EntityType')
		->disableOriginalConstructor()
		->getMock();
		
		$mockEntityType->expects($this->any())->method('getName')
		->will($this->returnValue('entity'));
		
		return array(new PreloadedExtension(array(
				$select2Type->getName() => $select2Type,
				$mockEntityType->getName() => $mockEntityType,
		), array()));
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