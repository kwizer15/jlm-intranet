<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InterventionPlannedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
      		->add('door',null,array('label'=>'Porte','attr'=>array('class'=>'input-xxlarge')))
      		->add('actionType',null,array('label'=>'Action'))
            ->add('contactName',null,array('label'=>'Nom du contact','required'=>false))
            ->add('contactPhones',null,array('label'=>'Téléphones','required'=>false))
            ->add('contactEmail','email',array('label'=>'e-mail','required'=>false,'attr'=>array('class'=>'input-xlarge')))
            ->add('reason',null,array('label'=>'Raison de l\'intervention','attr'=>array('class'=>'input-xxlarge')))
            ->add('priority','choice',array('label'=>'Priorité','choices'=>array(1=>'TRES URGENT',2=>'Urgent',3=>'Haute',4=>'Normal',5=>'Basse',6=>'Très basse')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\DailyBundle\Entity\InterventionPlanned'
        ));
    }

    public function getName()
    {
        return 'jlm_dailybundle_interventionplannedtype';
    }
}
