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
            ->add('trustee','trustee_hidden',array('required'=>false))
            ->add('trusteeName',null,array('label'=>'Syndic'))
            ->add('trusteeAddress',null,array('label'=>'Adresse de facturation','attr'=>array('class'=>'input-xlarge')))
            ->add('contact','sitecontact_hidden',array('required'=>false))
            ->add('contactCp',null,array('label'=>'A l\'attention de'))
            ->add('discount','percent',array('label'=>'Remise','attr'=>array('class'=>'input-mini')))
            ->add('follower','hidden',array('required'=>false))
            ->add('followerCp',null,array('label'=>'Suivi par'))
            ->add('door','door_hidden',array('required'=>false))
            ->add('doorCp',null,array('label'=>'Affaire','attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            ->add('vat','percent',array('precision'=>1,'label'=>'TVA applicable','attr'=>array('class'=>'input-mini')))
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
    			'data_class' => 'JLM\ModelBundle\Entity\Quote'
    	));
    }
    
    public function getName()
    {
        return 'quote';
    }
}
