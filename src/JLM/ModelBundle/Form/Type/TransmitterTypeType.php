<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TransmitterTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nom']);
    }

    public function getName()
    {
        return 'jlm_modelbundle_transmittertypetype';
    }

    public function getDefaultOptions(array $options)
    {
        return ['data_class' => 'JLM\ModelBundle\Entity\TransmitterType'];
    }
}
