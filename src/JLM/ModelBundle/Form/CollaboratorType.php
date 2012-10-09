<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CollaboratorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('role')
            ->add('phones','collection')
            ->add('emails','collection')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_collaboratortype';
    }
}
