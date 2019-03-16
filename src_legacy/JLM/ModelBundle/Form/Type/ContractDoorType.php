<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ContactBundle\Form\Type\AddressType;
use JLM\ModelBundle\Entity\Door;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContractDoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class, ['label' => 'Type de porte'])
            ->add('address', AddressType::class, ['label' => 'Adresse'])
            ->add('location', TextType::class, ['label' => 'Localisation'])
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return ['data_class' => Door::class];
    }
}
