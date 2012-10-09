<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocumentContentLineType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('designation')
            ->add('quantity')
            ->add('vat')
            ->add('unitPrice')
            ->add('document')
            ->add('product')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_documentcontentlinetype';
    }
}
