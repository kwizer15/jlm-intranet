<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuoteLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('product','product_hidden',array('required'=>false))
        	->add('reference',null,array('required'=>false,'attr'=>array('class'=>'input-mini')))
        	->add('designation',null,array('attr'=>array('class'=>'input-xlarge')))
        	->add('description',null,array('required'=>false,'attr'=>array('class'=>'input-xxlarge')))
        	->add('showDescription','hidden')
        	->add('quantity',null,array('attr'=>array('class'=>'span1')))
        	->add('unitPrice','money',array('attr'=>array('class'=>'input-mini')))
        	->add('discount','percent',array('attr'=>array('class'=>'span1')))
        	->add('vat','percent',array('attr'=>array('class'=>'input-mini')))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\ModelBundle\Entity\QuoteLine'
    	));
    }
    
    public function getName()
    {
        return 'quote_line';
    }
}