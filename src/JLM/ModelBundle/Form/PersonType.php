<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('phones')
            ->add('emails')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_persontype';
    }
}
