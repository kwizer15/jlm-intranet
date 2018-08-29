<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name');
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortypetype';
    }

    public function getDefaultOptions(array $options)
    {
        return ['data_class' => 'JLM\ModelBundle\Entity\DoorType'];
    }
}
