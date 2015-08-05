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
use JLM\CommerceBundle\EventListener\BillTypeSubscriber;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillType extends AbstractType
{
	private $om;
	
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
        	->add('intervention','intervention_hidden',array('required'=>false))
        	->add('siteObject','site_hidden',array('required'=>false))
            ->add('creation','datepicker')
            ->add('trustee','trustee_hidden',array('required'=>false))
            ->add('prelabel',null,array('required'=>false))
            ->add('trusteeName')
            ->add('trusteeAddress',null,array('attr'=>array('class'=>'input-xlarge')))
            ->add('accountNumber')
            
            ->add('reference',null,array('attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            ->add('site',null,array('attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            ->add('details',null,array('attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            
            ->add('discount','percent',array('attr'=>array('class'=>'input-mini')))
            ->add('maturity',null,array('attr'=>array('class'=>'input-mini')))
            ->add('property',null,array('required'=>false,'attr'=>array('class'=>'input-xxlarge')))
            
            ->add('earlyPayment',null,array('attr'=>array('class'=>'input-xxlarge')))
            ->add('penalty',null,array('attr'=>array('class'=>'input-xxlarge')))
            
            ->add('intro',null,array('required'=>false,'attr'=>array('class'=>'span12','placeholder'=>'Suite à ...')))
            ->add('lines','collection',array('prototype'=>true,'allow_add'=>true,'allow_delete'=>true,'type'=>'jlm_commerce_bill_line'))
            
            ->add('vat','percent',array('precision'=>1,'attr'=>array('class'=>'input-mini')))
            ->add('vatTransmitter','hidden')
            
            ->addEventSubscriber(new BillTypeSubscriber($this->om))
         ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\CommerceBundle\Entity\Bill'
    	));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_commerce_bill';
    }
}
