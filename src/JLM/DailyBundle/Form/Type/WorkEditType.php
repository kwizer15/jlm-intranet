<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WorkEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('door','door_hidden')
	        ->add('place','textarea',array('label'=>'Porte','attr'=>array('class'=>'input-xlarge')))
        	->add('reason',null,array('label'=>'Raison de l\'intervention','attr'=>array('class'=>'input-xxlarge')))
            ->add('contactName',null,array('label'=>'Nom du contact','required'=>false))
            ->add('contactPhones',null,array('label'=>'Téléphones','required'=>false))
            ->add('contactEmail','email',array('label'=>'e-mail','required'=>false,'attr'=>array('class'=>'input-xlarge')))
            ->add('priority','choice',array('label'=>'Priorité','choices'=>array(1=>'TRES URGENT',2=>'Urgent',3=>'Haute',4=>'Normal',5=>'Basse',6=>'Très basse')))
            ->add('category',null,array('label'=>'Type de travaux'))
            ->add('objective',null,array('label'=>'Objectif'))
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
        return 'jlm_dailybundle_workedittype';
    }
}
