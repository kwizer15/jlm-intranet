<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation','datepicker',array('label'=>'Date de création'))
            ->add('trustee','trustee_hidden',array('required'=>false))
            ->add('prelabel',null,array('label'=>'Libellé de facturation','required'=>false))
            ->add('trusteeName',null,array('label'=>'Syndic'))
            ->add('trusteeAddress',null,array('label'=>'Adresse de facturation','attr'=>array('class'=>'input-xlarge')))
            ->add('accountNumber',null,array('label'=>'Numéro de compte'))
            
            ->add('reference',null,array('label'=>'Références','attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            ->add('site',null,array('label'=>'Affaire','attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            ->add('details',null,array('label'=>'Détails','attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            
            ->add('discount','percent',array('label'=>'Remise','attr'=>array('class'=>'input-mini')))
            ->add('maturity','datepicker',array('label'=>'Echéance','required'=>false,'attr'=>array('class'=>'input-small')))
            ->add('property',null,array('label'=>'Clause de propriété','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
            
            ->add('earlyPayment',null,array('label'=>'Escompte','attr'=>array('class'=>'input-xxlarge')))
            ->add('penalty',null,array('label'=>'Penalités','attr'=>array('class'=>'input-xxlarge')))
            
            ->add('intro',null,array('label'=>'Introduction','required'=>false,'attr'=>array('class'=>'span12','placeholder'=>'Suite à ...')))
            ->add('lines','collection',array('prototype'=>true,'allow_add'=>true,'allow_delete'=>true,'type'=>'bill_line'))
            
            ->add('vat','percent',array('precision'=>1,'label'=>'TVA applicable','attr'=>array('class'=>'input-mini')))
            ->add('vatTransmitter','hidden')
         ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\OfficeBundle\Entity\Bill'
    	));
    }
    
    public function getName()
    {
        return 'bill';
    }
}
