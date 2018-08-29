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
class BillType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intervention', 'intervention_hidden', ['required' => false])
            ->add('siteObject', 'site_hidden', ['required' => false])
            ->add('creation', 'datepicker', ['label' => 'Date de création'])
            ->add('trustee', 'trustee_hidden', ['required' => false])
            ->add('prelabel', null, ['label' => 'Libellé de facturation', 'required' => false])
            ->add('trusteeName', null, ['label' => 'Syndic'])
            ->add('trusteeAddress', null, ['label' => 'Adresse de facturation', 'attr' => ['class' => 'input-xlarge']])
            ->add('accountNumber', null, ['label' => 'Numéro de compte'])
            ->add('reference', null, ['label' => 'Références', 'attr' => ['class' => 'input-xlarge', 'rows' => '3']])
            ->add('site', null, ['label' => 'Affaire', 'attr' => ['class' => 'input-xlarge', 'rows' => '3']])
            ->add('details', null, ['label' => 'Détails', 'attr' => ['class' => 'input-xlarge', 'rows' => '3']])
            ->add('discount', 'percent', ['label' => 'Remise', 'attr' => ['class' => 'input-mini']])
            ->add('maturity', null, ['label' => 'Echéance', 'attr' => ['class' => 'input-mini']])
            ->add(
                'property',
                null,
                ['label' => 'Clause de propriété', 'required' => false, 'attr' => ['class' => 'input-xxlarge']]
            )
            ->add('earlyPayment', null, ['label' => 'Escompte', 'attr' => ['class' => 'input-xxlarge']])
            ->add('penalty', null, ['label' => 'Penalités', 'attr' => ['class' => 'input-xxlarge']])
            ->add(
                'intro',
                null,
                [
                    'label' => 'Introduction',
                    'required' => false,
                    'attr' => ['class' => 'span12', 'placeholder' => 'Suite à ...'],
                ]
            )
            ->add(
                'lines',
                'collection',
                ['prototype' => true, 'allow_add' => true, 'allow_delete' => true, 'type' => 'jlm_commerce_bill_line']
            )
            ->add(
                'vat',
                'percent',
                ['precision' => 1, 'label' => 'TVA applicable', 'attr' => ['class' => 'input-mini']]
            )
            ->add('vatTransmitter', 'hidden')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\CommerceBundle\Entity\Bill']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_commerce_bill';
    }
}
