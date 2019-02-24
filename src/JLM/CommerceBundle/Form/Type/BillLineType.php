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

use JLM\CommerceBundle\Entity\BillLine;
use JLM\ProductBundle\Form\Type\ProductHiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillLineType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', HiddenType::class)
            ->add('product', ProductHiddenType::class, ['required' => false])
            ->add('reference', TextType::class, ['required' => false, 'attr' => ['class' => 'input-mini']])
            ->add('designation', TextType::class, ['attr' => ['class' => 'input-xlarge']])
            ->add('description', TextType::class, ['required' => false, 'attr' => ['class' => 'input-xlarge']])
            ->add('showDescription', HiddenType::class)
            ->add('quantity', TextType::class, ['attr' => ['class' => 'input-mini']])
            ->add('unitPrice', MoneyType::class, ['grouping' => true, 'attr' => ['class' => 'input-mini']])
            ->add('discount', PercentType::class, ['scale' => 0, 'attr' => ['class' => 'input-mini']])
            ->add('vat', PercentType::class, ['scale' => 1, 'attr' => ['class' => 'input-mini']])
            ->add('isTransmitter', HiddenType::class)

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => BillLine::class]);
    }
}
