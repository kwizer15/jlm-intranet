<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuoteVariantType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('creation','datepicker',array('label'=>'Date de création'))
			->add('discount','percent',array('label'=>'Remise','attr'=>array('class'=>'input-mini')))
			->add('paymentRules',null,array('label'=>'Réglement','attr'=>array('class'=>'input-xxlarge')))
			->add('deliveryRules',null,array('label'=>'Délai','attr'=>array('class'=>'input-xxlarge')))
			->add('customerComments',null,array('label'=>'Observations','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
			->add('intro',null,array('label'=>'Introduction','attr'=>array('class'=>'span12','placeholder'=>'Suite à ...')))
			->add('lines','collection',array('prototype'=>true,'allow_add'=>true,'allow_delete'=>true,'type'=>'quote_line'))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\OfficeBundle\Entity\QuoteVariant'
		));
	}

	public function getName()
	{
		return 'quote';
	}
}
