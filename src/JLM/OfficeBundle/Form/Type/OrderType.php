<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('creation','datepicker',array('label'=>'Date de création'))
		->add('place',null,array('label'=>'Référence','attr'=>array('class'=>'input-xlarge','rows'=>'5')))
		->add('lines','collection',array('prototype'=>true,'allow_add'=>true,'allow_delete'=>true,'type'=>'order_line'))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\OfficeBundle\Entity\Order'
		));
	}

	public function getName()
	{
		return 'order';
	}
}