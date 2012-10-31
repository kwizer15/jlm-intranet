<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation','datepicker',array('label'=>'Date de création'))
            ->add('trustee','hidden',array('required'=>false))
            ->add('trusteeName',null,array('label'=>'Syndic'))
            ->add('trusteeAddress',null,array('label'=>'Adresse de facturation','attr'=>array('class'=>'input-xlarge')))
            ->add('discount','percent',array('label'=>'Remise','attr'=>array('class'=>'input-mini')))
            ->add('follower','hidden',array('required'=>false))
            ->add('followerCp',null,array('label'=>'Suivi par'))
            ->add('door','hidden',array('required'=>false))
            ->add('doorCp',null,array('label'=>'Affaire','attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            ->add('paymentRules',null,array('label'=>'Réglement','attr'=>array('class'=>'input-xxlarge')))
            ->add('deliveryRules',null,array('label'=>'Délai','attr'=>array('class'=>'input-xxlarge')))
            ->add('customerComments',null,array('label'=>'Observations','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
            ->add('intro',null,array('label'=>'Introduction','attr'=>array('class'=>'span12','placeholder'=>'Suite à ...')))
            ->add('lines','collection',array('prototype'=>true,'allow_add'=>true,'type'=>'quote_line'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\ModelBundle\Entity\Quote'
    	));
    }
    
    public function getName()
    {
        return 'quote';
    }
}
