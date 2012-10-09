<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContractTypeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('complete')
            ->add('options')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_contracttypetype';
    }
}
