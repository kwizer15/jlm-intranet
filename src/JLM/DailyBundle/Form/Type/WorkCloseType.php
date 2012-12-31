<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WorkCloseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('report','textarea',array('label'=>'Rapport','attr'=>array('class'=>'input-xxlarge')))
        	->add('comments','textarea',array('label'=>'Commentaires','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\DailyBundle\Entity\Work'
        ));
    }

    public function getName()
    {
        return 'jlm_dailybundle_workclosetype';
    }
}
