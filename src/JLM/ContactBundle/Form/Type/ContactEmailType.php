<?php
namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JLM\ContactBundle\Entity\ContactEmail;

class ContactEmailType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('contactdata', new ContactDataType(), array('data_class' => 'JLM\ContactBundle\Entity\ContactEmail'))
				->add('email',new EmailType(),array('label'=>'Adresse','required'=>true,'attr'=>array('class'=>'input-xlarge')))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'jlm_contactbundle_contactemailtype';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\ContactBundle\Entity\ContactEmail',
				'empty_data' => function (FormInterface $form) {
					$datas = $form->get('contactdata');
					return new ContactEmail($datas->get('contact')->getData(), $datas->get('alias')->getData(), $form->get('email')->getData());
				}
		));
	}
}