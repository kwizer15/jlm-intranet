<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TrusteeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('accession')
            ->add('accountNumber')
            ->add('mainAddress')
            ->add('billingAddress')
            ->add('doors')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_trusteetype';
    }
}
