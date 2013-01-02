<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FixingCloseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('due',null,array('label'=>'Cause','attr'=>array('class'=>'input-large')))
	        ->add('done',null,array('label'=>'Action','attr'=>array('class'=>'input-large')))
	        ->add('report','textarea',array('label'=>'Rapport','attr'=>array('class'=>'input-xxlarge')))
	        ->add('rest','textarea',array('label'=>'Reste à faire','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
        	->add('comments','textarea',array('label'=>'Commentaires','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\DailyBundle\Entity\Fixing'
        ));
    }

    public function getName()
    {
        return 'jlm_dailybundle_fixingclosetype';
    }
}
