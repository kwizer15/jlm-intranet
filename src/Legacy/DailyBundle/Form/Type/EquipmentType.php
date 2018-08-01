<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EquipmentType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('place',null,array('label'=>'Lieu'))
			->add('reason',null,array('label'=>'Raison'))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\DailyBundle\Entity\Equipment'
		));
	}

	public function getName()
	{
		return 'jlm_dailybundle_equipmenttype';
	}
}