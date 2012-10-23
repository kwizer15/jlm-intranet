<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>'Nom'))
            ->add('parent',null,array('required'=>false,'label'=>'Famille parente'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_productcategorytype';
    }
}
