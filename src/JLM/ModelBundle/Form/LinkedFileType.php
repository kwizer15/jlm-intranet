<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LinkedFileType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            ->add('product')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_linkedfiletype';
    }
}
