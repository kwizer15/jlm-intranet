<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Form\Type;

use JLM\CommerceBundle\Entity\Bill;
use JLM\DailyBundle\Form\Type\InterventionHiddenType;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\ModelBundle\Form\Type\SiteHiddenType;
use JLM\ModelBundle\Form\Type\TrusteeHiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intervention', InterventionHiddenType::class, ['required' => false])
            ->add('siteObject', SiteHiddenType::class, ['required' => false])
            ->add('creation', DatepickerType::class, ['label' => 'Date de création'])
            ->add('trustee', TrusteeHiddenType::class, ['required' => false])
            ->add('prelabel', TextType::class, ['label' => 'Libellé de facturation', 'required' => false])
            ->add('trusteeName', TextType::class, ['label' => 'Syndic'])
            ->add(
                'trusteeAddress',
                TextType::class,
                ['label' => 'Adresse de facturation', 'attr' => ['class' => 'input-xlarge']]
            )
            ->add('accountNumber', TextType::class, ['label' => 'Numéro de compte'])
            ->add(
                'reference',
                TextType::class,
                ['label' => 'Références', 'attr' => ['class' => 'input-xlarge', 'rows' => '3']]
            )
            ->add('site', TextType::class, ['label' => 'Affaire', 'attr' => ['class' => 'input-xlarge', 'rows' => '3']])
            ->add(
                'details',
                TextType::class,
                ['label' => 'Détails', 'attr' => ['class' => 'input-xlarge', 'rows' => '3']]
            )
            ->add('discount', PercentType::class, ['label' => 'Remise', 'attr' => ['class' => 'input-mini']])
            ->add('maturity', TextType::class, ['label' => 'Echéance', 'attr' => ['class' => 'input-mini']])
            ->add(
                'property',
                TextType::class,
                ['label' => 'Clause de propriété', 'required' => false, 'attr' => ['class' => 'input-xxlarge']]
            )
            ->add('earlyPayment', TextType::class, ['label' => 'Escompte', 'attr' => ['class' => 'input-xxlarge']])
            ->add('penalty', TextType::class, ['label' => 'Penalités', 'attr' => ['class' => 'input-xxlarge']])
            ->add(
                'intro',
                TextType::class,
                [
                    'label' => 'Introduction',
                    'required' => false,
                    'attr' => ['class' => 'span12', 'placeholder' => 'Suite à ...'],
                ]
            )
            ->add(
                'lines',
                CollectionType::class,
                ['prototype' => true, 'allow_add' => true, 'allow_delete' => true, 'type' => BillLineType::class]
            )
            ->add(
                'vat',
                PercentType::class,
                ['precision' => 1, 'label' => 'TVA applicable', 'attr' => ['class' => 'input-mini']]
            )
            ->add('vatTransmitter', HiddenType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Bill::class]);
    }
}
