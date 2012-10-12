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
            ->add('interlocutors','collection',array('label'=>'Interlocuteurs'))
            ->add('accession','choice',array('label'=>'Accession/Social','choices'=>array('1'=>'Accession','0'=>'Social'),'expanded'=>true,'multiple'=>false))
            ->add('accountNumber',null,array('label'=>'Numéro de compte'))
            ->add('contracts','collection',array('label'=>'Contrats')) // contrat -----> portes
            
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_trusteetype';
    }
}
