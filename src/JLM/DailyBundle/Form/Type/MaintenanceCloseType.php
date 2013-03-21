<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MaintenanceCloseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('report','textarea',array('label'=>'Rapport','attr'=>array('class'=>'input-xlarge')))
	        ->add('rest','textarea',array('label'=>'Reste à faire','required'=>false,'attr'=>array('class'=>'input-xlarge')))
	        ->add('voucher',null,array('label'=>'Bon d\'intervention','required'=>false,'attr'=>array('class'=>'input-small')))
        	->add('comments','textarea',array('label'=>'Commentaires','required'=>false,'attr'=>array('class'=>'input-xlarge')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\DailyBundle\Entity\Maintenance'
        ));
    }

    public function getName()
    {
        return 'jlm_dailybundle_maintenanceclosetype';
    }
}
