<?php
namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JLM\ContactBundle\Entity\Address;
use JLM\ContactBundle\Entity\ContactAddress;

class ContactAddressType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('contact','hiddencontacttype',array('required'=>true))
				->add('alias',null,array('label'=>'Nom de l\'adresse','required'=>true,'attr'=>array('class'=>'input-xlarge')))
				->add('label',null,array('label'=>'Destinataire','attr'=>array('class'=>'input-xlarge')))
				->add('address',new AddressType(),array('label'=>'Adresse','required'=>true,'attr'=>array('class'=>'input-xlarge')))
				->add('main',null,array('label'=>'Adresse principale'));
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'jlm_contactbundle_contactaddresstype';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\ContactBundle\Entity\ContactAddress',
				'empty_data' => function (FormInterface $form) {
					$datas = $form->getData();
					return new ContactAddress($form->get('contact')->getData(), $form->get('alias')->getData(), $form->get('address')->getData());
				}
		));
	}
}