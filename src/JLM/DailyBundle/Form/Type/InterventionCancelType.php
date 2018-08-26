<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InterventionCancelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('report', null, ['label'=>'Raison de l\'annulation'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'JLM\DailyBundle\Entity\Intervention'
        ]);
    }

    public function getName()
    {
        return 'jlm_dailybundle_interventioncanceltype';
    }
}
