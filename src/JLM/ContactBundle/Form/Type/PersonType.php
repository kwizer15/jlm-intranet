<?php
namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JLM\ContactBundle\Entity\Person;

class PersonType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('title','choice',array('choices'=>array('M.', 'Mme', 'Mlle'),'label'=>'Titre','attr'=>array('class'=>'input-mini')))
				->add('firstName',null,array('label'=>'Prénom','attr'=>array('class'=>'input-xlarge')))
				->add('lastName',null,array('label'=>'Nom','attr'=>array('class'=>'input-xlarge')))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'jlm_contactbundle_persontype';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		parent::setDefaultOptions($resolver);
		$resolver->setDefaults(array(
				'data_class' => 'JLM\ContactBundle\Entity\Person',
				'empty_data' => function (FormInterface $form) {
					return new Person($form->get('title')->getData(), $form->get('firstName')->getData(), $form->get('lastName')->getData());
				}
		));
	}
}