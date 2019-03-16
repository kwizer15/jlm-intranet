<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ModelBundle\Entity\DoorModel;
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

    public function getDefaultOptions(array $options)
    {
        return ['data_class' => DoorModel::class];
    }
}
