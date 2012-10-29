<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation','datepicker',array('label'=>'Date de création'))
            ->add('trustee','hidden')
            ->add('trusteeName',null,array('label'=>'Syndic'))
            ->add('trusteeAddress',null,array('label'=>'Adresse de facturation'))
            ->add('discount','percent',array('label'=>'Remise','attr'=>array('class'=>'input-mini')))
            ->add('follower','hidden')
            ->add('followerCp',null,array('label'=>'Suivi par'))
            ->add('door','hidden')
            ->add('doorCp',null,array('label'=>'Affaire'))
            ->add('paymentRules','choice',array('label'=>'Réglement','choices'=>array('à réception de la facture', '30% à la commande, le solde fin de travaux'),'attr'=>array('class'=>'input-xxlarge')))
            ->add('deliveryRules','choice',array('label'=>'Délai','choices'=>array('10 à 15 jours après accord'),'attr'=>array('class'=>'input-xxlarge')))
            ->add('customerComments',null,array('label'=>'Observations','attr'=>array('class'=>'input-xxlarge')))
            ->add('given',null,array('label'=>'Accordé'))
            ->add('intro',null,array('label'=>'Introduction','attr'=>array('class'=>'span12','placeholder'=>'Suite à ...')))
            
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_quotetype';
    }
}
