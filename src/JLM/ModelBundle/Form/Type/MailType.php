<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', 'email', ['label' => 'De', 'attr' => ['class' => 'input-xxlarge']])
            ->add('to', 'email', ['label' => 'Destinataire', 'attr' => ['class' => 'input-xxlarge']])
            ->add('cc', 'email', ['label' => 'Copie à', 'required' => false, 'attr' => ['class' => 'input-xxlarge']])
            ->add('subject', 'text', ['label' => 'Sujet', 'attr' => ['class' => 'input-xxlarge']])
            ->add('body', 'textarea', ['label' => 'Message', 'attr' => ['class' => 'input-xxlarge', 'rows' => 7]])
            ->add(
                'signature',
                'textarea',
                ['label' => 'Signature', 'attr' => ['class' => 'input-xxlarge', 'rows' => 5]]
            )
        ;
    }

    public function getName()
    {
        return 'mail';
    }
}
