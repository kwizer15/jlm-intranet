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

use JLM\CommerceBundle\Entity\QuoteVariant;
use JLM\ModelBundle\Form\Type\DatepickerType;
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
class QuoteVariantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quote', QuoteHiddenType::class)
            ->add('creation', DatepickerType::class, ['label' => 'Date de création'])
            ->add('discount', PercentType::class, ['label' => 'Remise', 'attr' => ['class' => 'input-mini']])
            ->add('paymentRules', TextType::class, ['label' => 'Réglement', 'attr' => ['class' => 'input-xxlarge']])
            ->add('deliveryRules', TextType::class, ['label' => 'Délai', 'attr' => ['class' => 'input-xxlarge']])
            ->add(
                'intro',
                TextType::class,
                ['label' => 'Introduction', 'attr' => ['class' => 'span12', 'placeholder' => 'Suite à ...']]
            )
            ->add(
                'lines',
                CollectionType::class,
                ['prototype' => true, 'allow_add' => true, 'allow_delete' => true, 'type' => QuoteLineType::class]
            )
            ->add('vat', HiddenType::class, ['mapped' => false])
            ->add('vatTransmitter', HiddenType::class, ['mapped' => false])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => QuoteVariant::class]);
    }
}
