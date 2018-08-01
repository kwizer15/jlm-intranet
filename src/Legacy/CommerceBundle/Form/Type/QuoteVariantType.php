<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('quote','quote_hidden')
			->add('creation','datepicker',array('label'=>'Date de création'))
			->add('discount','percent',array('label'=>'Remise','attr'=>array('class'=>'input-mini')))
			->add('paymentRules',null,array('label'=>'Réglement','attr'=>array('class'=>'input-xxlarge')))
			->add('deliveryRules',null,array('label'=>'Délai','attr'=>array('class'=>'input-xxlarge')))
			->add('intro',null,array('label'=>'Introduction','attr'=>array('class'=>'span12','placeholder'=>'Suite à ...')))
			->add('lines','collection',array('prototype'=>true,'allow_add'=>true,'allow_delete'=>true,'type'=>'quote_line'))
			->add('vat', 'hidden', array('mapped' => false))
			->add('vatTransmitter', 'hidden', array('mapped' => false))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\CommerceBundle\Entity\QuoteVariant'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'quote_variant';
	}
}
