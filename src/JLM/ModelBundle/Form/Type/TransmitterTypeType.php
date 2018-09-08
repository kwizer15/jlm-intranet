<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ModelBundle\Entity\TransmitterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TransmitterTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom']);
    }

    public function getDefaultOptions(array $options)
    {
        return ['data_class' => TransmitterType::class];
    }
}
