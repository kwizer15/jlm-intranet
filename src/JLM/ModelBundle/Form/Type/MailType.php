<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from','email',array('label'=>'De','attr'=>array('class'=>'input-xxlarge')))
            ->add('to','email',array('label'=>'Destinataire','attr'=>array('class'=>'input-xxlarge')))
            ->add('subject','text',array('label'=>'Sujet','attr'=>array('class'=>'input-xxlarge')))
            ->add('body','textarea',array('label'=>'Message','attr'=>array('class'=>'input-xxlarge','rows'=>7)))
            ->add('signature','textarea',array('label'=>'Signature','attr'=>array('class'=>'input-xxlarge','rows'=>5)))
    	;
    }

    public function getName()
    {
        return 'mail';
    }
}