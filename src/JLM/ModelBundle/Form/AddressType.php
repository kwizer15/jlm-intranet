<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('street')
            ->add('zip')
            ->add('city')
            ->add('supplement')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_addresstype';
    }
}
