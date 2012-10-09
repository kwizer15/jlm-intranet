<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TrusteeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>'Nom'))
            ->add('accession','choice',array('label'=>'Accession/Social','choices'=>array('1'=>'Accession','0'=>'Social'),'expanded'=>true,'multiple'=>false))
            ->add('accountNumber',null,array('label'=>'Numéro de compte'))
            ->add('mainAddress', new AddressType,array('label'=>'Adresse'))
            ->add('billingAddress', new AddressType,array('label'=>'Adresse de facturation (si différente)','required'=>false))
            ->add('doors','collection',array('label'=>'Portes'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_trusteetype';
    }
}
