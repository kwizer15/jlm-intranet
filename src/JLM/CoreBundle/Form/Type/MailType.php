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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                'collection',
                [
                    'type' => 'jlm_core_email',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'label' => 'De',
                ]
            )
            ->add(
                'to',
                'collection',
                [
                    'type' => 'jlm_core_email',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'label' => 'Destinataire',
                ]
            )
            ->add(
                'cc',
                'collection',
                [
                    'type' => 'jlm_core_email',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'label' => 'Copie à',
                    'required' => false,
                ]
            )
            ->add('subject', 'text', ['label' => 'Sujet', 'attr' => ['class' => 'input-xxlarge']])
            ->add('body', 'textarea', ['label' => 'Message', 'attr' => ['class' => 'input-xxlarge', 'rows' => 7]])
            ->add(
                'preAttachements',
                'collection',
                ['type' => 'jlm_core_preattachement', 'label' => 'Fichiers joints', 'disabled' => true]
            )
            // ->add(
            //     'attachements',
            //     'collection',
            //     [
            //         'type' => 'jlm_core_attachement',
            //         'allow_add' => true,
            //         'allow_delete' => true,
            //         'prototype' => true,
            //         'label' => 'Fichiers joints',
            //     ]
            // )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_core_mail';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'JLM\CoreBundle\Entity\Email',
                'csrf_protection' => false,
            ]
        );
    }
}
