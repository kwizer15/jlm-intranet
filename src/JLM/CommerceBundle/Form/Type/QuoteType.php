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
class QuoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation', 'datepicker', ['label'=>'Date de création'])
            ->add('trustee', 'trustee_hidden', ['required'=>false])
            ->add('trusteeName', null, ['label'=>'Syndic'])
            ->add('trusteeAddress', null, ['label'=>'Adresse de facturation','attr'=>['class'=>'input-xlarge']])
            ->add('contact', 'sitecontact_hidden', ['required'=>false])
            ->add('contactCp', null, ['label'=>'A l\'attention de'])
            ->add('follower', 'hidden', ['required'=>false])
            ->add('followerCp', null, ['label'=>'Suivi par'])
            ->add('door', 'door_hidden', ['required'=>false])
            ->add('doorCp', null, ['label'=>'Affaire','attr'=>['class'=>'input-xlarge','rows'=>'3']])
            ->add('vat', 'percent', ['precision'=>1,'label'=>'TVA applicable','attr'=>['class'=>'input-mini']])
            ->add('description', 'textarea', ['required' => false])
            ->add('vatTransmitter', 'hidden')
            ->add('ask', 'askquote_hidden')
         ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                'data_class' => 'JLM\CommerceBundle\Entity\Quote'
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'quote';
    }
}
