<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Form\Type;

use JLM\ProductBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference', TextType::class, ['label' => 'Référence', 'attr' => ['class' => 'input-small']])
            ->add('category', TextType::class, ['label' => 'Famille de produit'])
            ->add('designation', TextType::class, ['label' => 'Designation', 'attr' => ['class' => 'input-xxlarge']])
            ->add(
                'description',
                TextType::class,
                ['label' => 'Description longue', 'required' => false, 'attr' => ['class' => 'input-xxlarge']]
            )
            ->add('supplier', TextType::class, ['label' => 'Fournisseur'])// Typeahead
            ->add('unity', TextType::class, ['label' => 'Unité', 'attr' => ['class' => 'input-small']])
            ->add(
                'purchase',
                MoneyType::class,
                ['label' => 'Prix d\'achat HT', 'grouping' => true, 'attr' => ['class' => 'input-small']]
            )
            ->add(
                'discountSupplier',
                PercentType::class,
                ['type' => 'integer', 'label' => 'Remise fournisseur', 'attr' => ['class' => 'input-mini']]
            )
            ->add(
                'expenseRatio',
                PercentType::class,
                ['type' => 'integer', 'label' => 'Frais', 'attr' => ['class' => 'input-mini']]
            )
            ->add('shipping', MoneyType::class, ['label' => 'Port', 'grouping' => true, 'attr' => ['class' => 'input-mini']])
            ->add('unitPrice', MoneyType::class, ['label' => 'PVHT', 'grouping' => true, 'attr' => ['class' => 'input-mini']])
            ->add('active', CheckboxType::class, ['required' => false])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(['data_class' => Product::class]);
    }
}
