<?php
namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('type',null,array('label'=>'Type'))
		->add('door','door_hidden',array('required'=>false))
		->add('place',null,array('label'=>'Lieu concerné'))
		->add('todo',null,array('label'=>'À faire'))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\OfficeBundle\Entity\Task'
		));
	}

	public function getName()
	{
		return 'task';
	}
}