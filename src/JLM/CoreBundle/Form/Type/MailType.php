<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Form\Type;

use JLM\CoreBundle\Entity\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class MailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'from',
                CollectionType::class,
                [
                    'type' => Email::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'label' => 'De',
                ]
            )
            ->add(
                'to',
                CollectionType::class,
                [
                    'type' => Email::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'label' => 'Destinataire',
                ]
            )
            ->add(
                'cc',
                CollectionType::class,
                [
                    'type' => Email::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'label' => 'Copie à',
                    'required' => false,
                ]
            )
            ->add('subject', TextType::class, ['label' => 'Sujet', 'attr' => ['class' => 'input-xxlarge']])
            ->add('body', TextareaType::class, ['label' => 'Message', 'attr' => ['class' => 'input-xxlarge', 'rows' => 7]])
            ->add(
                'preAttachements',
                CollectionType::class,
                ['type' => PreAttachementType::class, 'label' => 'Fichiers joints', 'disabled' => true]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Email::class,
                'csrf_protection' => false,
            ]
        );
    }
}
