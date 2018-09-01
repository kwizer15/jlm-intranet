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

use Symfony\Component\Form\AbstractType;
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
            ->add('reference', null, ['label' => 'Référence', 'attr' => ['class' => 'input-small']])
            ->add('category', null, ['label' => 'Famille de produit'])
            ->add('designation', null, ['label' => 'Designation', 'attr' => ['class' => 'input-xxlarge']])
            ->add(
                'description',
                null,
                ['label' => 'Description longue', 'required' => false, 'attr' => ['class' => 'input-xxlarge']]
            )
            ->add('supplier', null, ['label' => 'Fournisseur'])// Typeahead
            ->add('unity', null, ['label' => 'Unité', 'attr' => ['class' => 'input-small']])
            ->add(
                'purchase',
                'money',
                ['label' => 'Prix d\'achat HT', 'grouping' => true, 'attr' => ['class' => 'input-small']]
            )
            ->add(
                'discountSupplier',
                'percent',
                ['type' => 'integer', 'label' => 'Remise fournisseur', 'attr' => ['class' => 'input-mini']]
            )
            ->add(
                'expenseRatio',
                'percent',
                ['type' => 'integer', 'label' => 'Frais', 'attr' => ['class' => 'input-mini']]
            )
            ->add('shipping', 'money', ['label' => 'Port', 'grouping' => true, 'attr' => ['class' => 'input-mini']])
            ->add('unitPrice', 'money', ['label' => 'PVHT', 'grouping' => true, 'attr' => ['class' => 'input-mini']])
            ->add('active', 'checkbox', ['required' => false])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_product_product';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(['data_class' => 'JLM\ProductBundle\Entity\Product']);
    }
}
