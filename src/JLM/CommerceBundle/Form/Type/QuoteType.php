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

use JLM\CommerceBundle\Entity\Quote;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\ModelBundle\Form\Type\DoorHiddenType;
use JLM\ModelBundle\Form\Type\SiteContactHiddenType;
use JLM\ModelBundle\Form\Type\TrusteeHiddenType;
use JLM\OfficeBundle\Form\Type\AskQuoteHiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation', DatepickerType::class, ['label' => 'Date de création'])
            ->add('trustee', TrusteeHiddenType::class, ['required' => false])
            ->add('trusteeName', TextType::class, ['label' => 'Syndic'])
            ->add(
                'trusteeAddress',
                TextType::class,
                ['label' => 'Adresse de facturation', 'attr' => ['class' => 'input-xlarge']]
            )
            ->add('contact', SiteContactHiddenType::class, ['required' => false])
            ->add('contactCp', TextType::class, ['label' => 'A l\'attention de'])
            ->add('follower', HiddenType::class, ['required' => false])
            ->add('followerCp', TextType::class, ['label' => 'Suivi par'])
            ->add('door', DoorHiddenType::class, ['required' => false])
            ->add(
                'doorCp',
                TextType::class,
                ['label' => 'Affaire', 'attr' => ['class' => 'input-xlarge', 'rows' => '3']]
            )
            ->add(
                'vat',
                PercentType::class,
                ['precision' => 1, 'label' => 'TVA applicable', 'attr' => ['class' => 'input-mini']]
            )
            ->add('description', TextareaType::class, ['required' => false])
            ->add('vatTransmitter', HiddenType::class)
            ->add('ask', AskQuoteHiddenType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => Quote::class]);
    }
}
