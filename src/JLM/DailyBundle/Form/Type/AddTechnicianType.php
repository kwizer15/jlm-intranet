<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddTechnicianType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//          ->add('creation','hidden',array('data_class'=>'\DateTime'))
//          ->add('shifting','shifting_hidden')
            ->add('technician', null, ['label'=>'Technicien'])
            ->add('begin', 'datepicker', ['label'=>'Date'])
            ->add('comment', 'textarea', ['label'=>'Commentaire','required'=>false,'attr'=>['class'=>'input-xlarge']])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'JLM\DailyBundle\Entity\ShiftTechnician'
        ]);
    }

    public function getName()
    {
        return 'jlm_dailybundle_addtechniciantype';
    }
}
