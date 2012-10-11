<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', null, array('label'=>'Nom'))
            ->add('phone', new PhoneType, array('label'=>'Téléphone'))
            ->add('email', new EmailType, array('label'=>'Email'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_suppliertype';
    }
}
