<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ModelBundle\Entity\DoorStop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorStopEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', TextareaType::class, ['label' => 'Raison'])
            ->add('state', TextareaType::class, ['label' => 'État'])
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return ['data_class' => DoorStop::class];
    }
}
