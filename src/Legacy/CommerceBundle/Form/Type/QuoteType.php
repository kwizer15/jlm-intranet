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
            ->add('creation','datepicker',array('label'=>'Date de création'))
            ->add('trustee','trustee_hidden',array('required'=>false))
            ->add('trusteeName',null,array('label'=>'Syndic'))
            ->add('trusteeAddress',null,array('label'=>'Adresse de facturation','attr'=>array('class'=>'input-xlarge')))
            ->add('contact','sitecontact_hidden',array('required'=>false))
            ->add('contactCp',null,array('label'=>'A l\'attention de'))
            ->add('follower','hidden',array('required'=>false))
            ->add('followerCp',null,array('label'=>'Suivi par'))
            ->add('door','door_hidden',array('required'=>false))
            ->add('doorCp',null,array('label'=>'Affaire','attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            ->add('vat','percent',array('precision'=>1,'label'=>'TVA applicable','attr'=>array('class'=>'input-mini')))
            ->add('description', 'textarea',array('required' => false))
            ->add('vatTransmitter','hidden')
            ->add('ask','askquote_hidden')
         ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\CommerceBundle\Entity\Quote'
    	));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'quote';
    }
}
