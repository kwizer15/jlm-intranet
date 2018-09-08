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

use JLM\CommerceBundle\Entity\VAT;
use JLM\ContractBundle\Form\Type\ContractSelectType;
use JLM\FeeBundle\Entity\Fee;
use JLM\ModelBundle\Form\Type\TrusteeSelectType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        ->add('trustee', TrusteeSelectType::class, ['label' => 'Syndic', 'attr' => ['class' => 'input-xlarge']])
        ->add('address', TextType::class, ['label' => 'Adresse', 'attr' => ['class' => 'input-xlarge']])
        ->add('prelabel', TextType::class, ['label' => 'Libélé', 'attr' => ['class' => 'input-xlarge']])
        ->add('frequence', ChoiceType::class, ['label' => 'Fréquence', 'choices' => [
            1 => 'Annuelle',
            2 => 'Semestrielle',
            4 => 'Trimestrielle'
        ], 'attr' => ['class' => 'input-normal']])
        ->add('vat', EntityType::class, [
            'label' => 'TVA',
            'class' => VAT::class,
            'attr' => ['class' => 'input-small']
        ])
        ->add('contracts', CollectionType::class, [
            'prototype' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'type' => ContractSelectType::class,
            'label' => 'Contrats'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Fee::class]);
    }
}
