<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContractDoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', null, ['label' => 'Type de porte'])
            ->add('address', 'address', ['label' => 'Adresse'])
            ->add('location', 'text', ['label' => 'Localisation'])
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_contractdoortype';
    }

    public function getDefaultOptions(array $options)
    {
        return ['data_class' => 'JLM\ModelBundle\Entity\Door'];
    }
}
