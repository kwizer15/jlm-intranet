<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductCategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('parent')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_productcategorytype';
    }
}
