<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('location')
            ->add('transmitters')
            ->add('trustees')
            ->add('address')
            ->add('contracts')
            ->add('type')
            ->add('parts')
            ->add('documents')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortype';
    }
}
