<?php

/*
 * This file is part of the JLMFeeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FeeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('trustee', 'trustee_select', ['label' => 'Syndic', 'attr' => ['class' => 'input-xlarge']])
        ->add('address', null, ['label' => 'Adresse', 'attr' => ['class' => 'input-xlarge']])
        ->add('prelabel', null, ['label' => 'Libélé', 'attr' => ['class' => 'input-xlarge']])
        ->add('frequence', 'choice', ['label' => 'Fréquence', 'choices' => [
            1 => 'Annuelle',
            2 => 'Semestrielle',
            4 => 'Trimestrielle'
        ], 'attr' => ['class' => 'input-normal']])
        ->add('vat', 'entity', [
            'label' => 'TVA',
            'class' => 'JLM\CommerceBundle\Entity\VAT',
            'attr' => ['class' => 'input-small']
        ])
        ->add('contracts', 'collection', [
            'prototype' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'type' => 'jlm_contract_contract_select',
            'label' => 'Contrats'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fee';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\FeeBundle\Entity\Fee']);
    }
}
