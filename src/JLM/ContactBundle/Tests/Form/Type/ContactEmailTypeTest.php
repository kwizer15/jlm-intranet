<?php
namespace JLM\ContactBundle\Tests\Form;

use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;

use JLM\ContactBundle\Form\Type\ContactEmailType;
use JLM\ContactBundle\Entity\ContactEmail;
use JLM\ContactBundle\Entity\Email;
use JLM\ContactBundle\Form\Type\HiddenContactType;



class ContactEmailTypeTest extends TypeTestCase
{
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
		
		$this->form = $this->factory->create(new ContactEmailType);
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
		$or = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
		$or->expects($this->any())->method('find')->will($this->returnValue($this->getContact()));
		
		$om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
		$om->expects($this->any())->method('getRepository')->will($this->returnValue($or));
		$hiddenContactType = new HiddenContactType($om);
		return array(new PreloadedExtension(array(
				$hiddenContactType->getName() => $hiddenContactType,
		), array()));
	}
	
	public function validData()
	{

		return array(
			array(
				array(
					'contact' => $this->getContact(),
					'alias'   => 'SAV',
					'email' => array(
						'address'=>'sav@jlm-entreprise.fr',
					),
				),
			),
				
		);
	}
	
	/**
	 * @dataProvider validData
	 */
	public function testSubmitValidData($data)
	{
		$email = new Email($data['email']['address']);
		
		$object = new ContactEmail($data['contact'],$data['alias'],$email);
		
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