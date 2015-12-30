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
        	->add('published','checkbox', array('label'=>'Publier', 'required'=>false))
        	->add('partFamily','jlm_daily_partfamilytype',array('label'=>'Famille de pièce','attr'=>array('class'=>'input-large')))
	        ->add('due',null,array('label'=>'Cause','attr'=>array('class'=>'input-large')))
	        ->add('done',null,array('label'=>'Action','attr'=>array('class'=>'input-large')))
	        ->add('observation',null,array('label'=>'Constat','attr'=>array('class'=>'input-xlarge')))
	        ->add('report','textarea',array('label'=>'Action menée','required'=>false,'attr'=>array('class'=>'input-xlarge')))
	        ->add('rest','textarea',array('label'=>'Reste à faire','required'=>false,'attr'=>array('class'=>'input-xlarge')))
	        ->add('voucher',null,array('label'=>'Bon d\'intervention','required'=>false,'attr'=>array('class'=>'input-small')))
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
