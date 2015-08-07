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
use JLM\CoreBundle\EventListener\FormEntitySubscriber;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantType extends AbstractType
{
	private $om;
	
	/**
	 * @param ObjectManager $om
	 */
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
    /**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('quote','quote_hidden')
			->add('creation','datepicker')
			->add('discount','percent',array('attr'=>array('class'=>'input-mini')))
			->add('paymentRules',null,array('attr'=>array('class'=>'input-xxlarge')))
			->add('deliveryRules',null,array('attr'=>array('class'=>'input-xxlarge')))
			->add('intro',null,array('attr'=>array('class'=>'span12','placeholder'=>'Suite à ...')))
			->add('lines','collection',array('prototype'=>true,'allow_add'=>true,'allow_delete'=>true,'type'=>'quote_line'))
			->add('vat', 'hidden', array('mapped' => false))
			->add('vatTransmitter', 'hidden', array('mapped' => false))
			->addEventSubscriber(new FormEntitySubscriber($this->om))
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
