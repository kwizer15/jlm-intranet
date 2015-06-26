<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class MailType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from','collection',array('type'=>'jlm_core_email','allow_add' => true,'allow_delete' => true, 'prototype' => true, 'label'=>'De'))
            ->add('to','collection',array('type'=>'jlm_core_email','allow_add' => true,'allow_delete' => true, 'prototype' => true, 'label'=>'Destinataire'))
            ->add('cc','collection',array('type'=>'jlm_core_email','allow_add' => true,'allow_delete' => true, 'prototype' => true, 'label'=>'Copie à','required'=>false))
            ->add('subject','text',array('label'=>'Sujet','attr'=>array('class'=>'input-xxlarge')))
            ->add('body','textarea',array('label'=>'Message','attr'=>array('class'=>'input-xxlarge','rows'=>7)))
    	;
    }

    /**
	 * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_core_mail';
    }
    
	/**
	 * {@inheritdoc}
	 */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\CoreBundle\Entity\Email',
    			'csrf_protection'   => false,
    	));
    }
}