<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('description')
            ->add('reference')
            ->add('barcode')
            ->add('margin')
            ->add('vat')
            ->add('supplier')
            ->add('parent')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_producttype';
    }
}
