<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuoteLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('position','hidden')
        	->add('product','product_hidden',array('required'=>false))
        	->add('reference',null,array('required'=>false,'attr'=>array('class'=>'input-mini')))
        	->add('designation',null,array('attr'=>array('class'=>'input-xlarge')))
        	->add('description',null,array('required'=>false,'attr'=>array('class'=>'input-xlarge')))
        	->add('showDescription','hidden')
        	->add('quantity',null,array('attr'=>array('class'=>'span1')))
        	->add('unitPrice','money',array('attr'=>array('class'=>'input-mini')))
        	->add('discount','percent',array('attr'=>array('class'=>'span1')))
        	->add('vat','percent',array('precision'=>1,'attr'=>array('class'=>'input-mini')))
        	->add('isTransmitter','hidden')

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\OfficeBundle\Entity\QuoteLine'
    	));
    }
    
    public function getName()
    {
        return 'quote_line';
    }
}