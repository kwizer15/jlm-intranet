<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocumentContentTextType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('text')
            ->add('document')
            ->add('model')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_documentcontenttexttype';
    }
}
