<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doormodeltype';
    }

    public function getDefaultOptions(array $options)
    {
        return ['data_class' => 'JLM\ModelBundle\Entity\DoorModel'];
    }
}
