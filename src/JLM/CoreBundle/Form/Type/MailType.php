<?php

namespace JLM\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MailType extends AbstractType
{
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

    public function getName()
    {
        return 'jlm_core_mail';
    }
    

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\CoreBundle\Entity\Email',
    			'csrf_protection'   => false,
    	));
    }
}