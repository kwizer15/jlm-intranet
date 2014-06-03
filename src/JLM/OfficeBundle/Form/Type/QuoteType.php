<?php

namespace JLM\OfficeBundle\Form\Type;

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
            ->add('trusteeAddress',null,array('label'=>'Adresse de facturation','attr'=>array('rows'=>'5')))
            ->add('contact','sitecontact_hidden',array('required'=>false))
            ->add('contactCp',null,array('label'=>'A l\'attention de'))
            ->add('follower','hidden',array('required'=>false))
            ->add('followerCp',null,array('label'=>'Suivi par'))
            ->add('door','door_hidden',array('required'=>false))
            ->add('doorCp',null,array('label'=>'Affaire','attr'=>array('rows'=>'6')))
            ->add('vat','percent',array('precision'=>1,'label'=>'TVA applicable'))
            ->add('vatTransmitter','hidden')
            ->add('ask','askquote_hidden')
         ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\OfficeBundle\Entity\Quote'
    	));
    }
    
    public function getName()
    {
        return 'quote';
    }
}
