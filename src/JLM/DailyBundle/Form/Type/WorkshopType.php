<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WorkshopType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('place',null,array('label'=>'Lieu'))
			->add('reason',null,array('label'=>'Raison'))
			->add('work','jlm_daily_work_select',array('label'=>'Travaux concernés'))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\DailyBundle\Entity\Workshop'
		));
	}

	public function getName()
	{
		return 'jlm_daily_workshop';
	}
}