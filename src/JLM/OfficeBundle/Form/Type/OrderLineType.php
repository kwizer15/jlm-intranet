<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderLineType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('position','hidden')
		->add('reference',null,array('required'=>false,'attr'=>array('class'=>'input-small')))
		->add('designation',null,array('attr'=>array('class'=>'input-xxlarge')))
		->add('quantity',null,array('attr'=>array('class'=>'input-mini')))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\OfficeBundle\Entity\OrderLine'
		));
	}

	public function getName()
	{
		return 'order_line';
	}
}