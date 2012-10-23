<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InterlocutorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('role')
            ->add('phones')
            ->add('emails')
            ->add('trustee')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_interlocutortype';
    }
}
