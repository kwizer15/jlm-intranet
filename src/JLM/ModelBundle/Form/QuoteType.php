<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation','date',array('format'=>'dd/MM/yyyy','label'=>'Date'))
            ->add('follower',null,array('label'=>'Suivi par'))
            ->add('trustee',null,array('label'=>'Client'))
            ->add('trusteeName',null,array('label'=>'Nom'))
            ->add('trusteeStreet',null,array('label'=>'Rue'))
            ->add('trusteeZip',null,array('label'=>'Code postal'))
            ->add('trusteeCity',null,array('label'=>'Ville'))
            ->add('trusteeInterlocutor',null,array('label'=>'Interlocuteur'))
            ->add('doors','collection',array('label'=>'Affaires'))
            ->add('customerComments',null,array('label'=>'Observations'))
            ->add('paymentRules',null,array('label'=>'Réglement'))
            ->add('deliveryRules',null,array('label'=>'Livraison'))
            
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_quotetype';
    }
}
