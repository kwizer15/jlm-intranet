<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CodingType extends AbstractType
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
            ->add('vatTransmitter','hidden')
            ->add('lines','collection',array('prototype'=>true,'allow_add'=>true,'allow_delete'=>true,'type'=>'coding_line'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\OfficeBundle\Entity\Coding'
    	));
    }
    
    public function getName()
    {
        return 'coding';
    }
}
