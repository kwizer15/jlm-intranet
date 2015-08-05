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
            ->add('creation','datepicker')
            ->add('trustee','trustee_hidden',array('required'=>false))
            ->add('trusteeName')
            ->add('trusteeAddress',null,array('attr'=>array('class'=>'input-xlarge')))
            ->add('contact','sitecontact_hidden',array('required'=>false))
            ->add('contactCp')
            ->add('follower','hidden',array('required'=>false))
            ->add('followerCp')
            ->add('door','door_hidden',array('required'=>false))
            ->add('doorCp',null,array('attr'=>array('class'=>'input-xlarge','rows'=>'3')))
            ->add('vat','percent',array('precision'=>1,'attr'=>array('class'=>'input-mini')))
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
