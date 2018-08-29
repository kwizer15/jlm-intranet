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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('quote', 'quote_hidden')
            ->add('creation', 'datepicker', ['label' => 'Date de création'])
            ->add('discount', 'percent', ['label' => 'Remise', 'attr' => ['class' => 'input-mini']])
            ->add('paymentRules', null, ['label' => 'Réglement', 'attr' => ['class' => 'input-xxlarge']])
            ->add('deliveryRules', null, ['label' => 'Délai', 'attr' => ['class' => 'input-xxlarge']])
            ->add(
                'intro',
                null,
                ['label' => 'Introduction', 'attr' => ['class' => 'span12', 'placeholder' => 'Suite à ...']]
            )
            ->add(
                'lines',
                'collection',
                ['prototype' => true, 'allow_add' => true, 'allow_delete' => true, 'type' => 'quote_line']
            )
            ->add('vat', 'hidden', ['mapped' => false])
            ->add('vatTransmitter', 'hidden', ['mapped' => false])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\CommerceBundle\Entity\QuoteVariant']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'quote_variant';
    }
}
