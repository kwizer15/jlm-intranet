<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('begin')
            ->add('endWarranty')
            ->add('end')
            ->add('turnover')
            ->add('type')
            ->add('doors')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_contracttype';
    }
}
