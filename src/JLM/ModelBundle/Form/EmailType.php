<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EmailType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('user')
            ->add('domain')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_emailtype';
    }
}
