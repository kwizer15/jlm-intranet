<?php
namespace JLM\ContactBundle\Tests\Form;

use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\PreloadedExtension;

use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;

use JLM\ContactBundle\Form\Type\ContactAddressType;
use JLM\ContactBundle\Entity\ContactAddress;
use JLM\ContactBundle\Entity\Address;
use JLM\ContactBundle\Entity\City;
use JLM\ContactBundle\Entity\Country;
use JLM\ContactBundle\Form\Type\HiddenContactType;
use Symfony\Component\DomCrawler\Form;


class ContactAddressTypeTest extends TypeTestCase
{
	private $contact;
	private $form;
	private $city;
	
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
		
		$this->form = $this->factory->create(new ContactAddressType);
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
						'contactdata'=>array(
					'contact' => $this->getContact(),
					'alias'   => 'Bureau',),
					'label'   => null,
					'address' => array(
						'street'=>'17, avenue de Montboulon',
						'city'=>new City('Saint-Soupplets','77165',new Country('FR','France'))
					),
					'main'    => true,
				),
			),
				
		);
	}
	
	/**
	 * @dataProvider validData
	 */
	public function testSubmitValidData($data)
	{
		$address = new Address($data['address']['street'],$data['address']['city']);
		
		$object = new ContactAddress($data['contactdata']['contact'],$data['contactdata']['alias'],$address);
		$object->setLabel($data['label']);
		$object->setMain($data['main']);
		
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