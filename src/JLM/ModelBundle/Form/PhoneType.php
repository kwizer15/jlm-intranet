<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PhoneType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('number')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_phonetype';
    }
}
