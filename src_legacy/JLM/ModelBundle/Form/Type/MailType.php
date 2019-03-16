<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', EmailType::class, ['label' => 'De', 'attr' => ['class' => 'input-xxlarge']])
            ->add('to', EmailType::class, ['label' => 'Destinataire', 'attr' => ['class' => 'input-xxlarge']])
            ->add(
                'cc',
                EmailType::class,
                ['label' => 'Copie à', 'required' => false, 'attr' => ['class' => 'input-xxlarge']]
            )
            ->add('subject', TextType::class, ['label' => 'Sujet', 'attr' => ['class' => 'input-xxlarge']])
            ->add(
                'body',
                TextareaType::class,
                ['label' => 'Message', 'attr' => ['class' => 'input-xxlarge', 'rows' => 7]]
            )
            ->add(
                'signature',
                TextareaType::class,
                ['label' => 'Signature', 'attr' => ['class' => 'input-xxlarge', 'rows' => 5]]
            )
        ;
    }
}
