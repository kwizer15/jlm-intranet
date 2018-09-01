<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WorkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('door', 'door_hidden')
            ->add('place', null, ['label' => 'Lieu', 'attr' => ['class' => 'input-xlarge']])
            ->add('quote', 'quotevariant_hidden', ['required' => false])
            ->add('reason', null, ['label' => 'Raison de l\'intervention', 'attr' => ['class' => 'input-xlarge']])
            ->add('contactName', null, ['label' => 'Nom du contact', 'required' => false])
            ->add('contactPhones', null, ['label' => 'Téléphones', 'required' => false])
            ->add(
                'contactEmail',
                'email',
                [
                 'label'    => 'e-mail',
                 'required' => false,
                 'attr'     => ['class' => 'input-xlarge'],
                ]
            )
            ->add('category', null, ['label' => 'Type de travaux'])
            ->add('objective', null, ['label' => 'Objectif'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                                'data_class' => 'JLM\DailyBundle\Entity\Work',
                                'attr'       => ['class' => 'interventionForm'],
                               ]);
    }

    public function getName()
    {
        return 'jlm_dailybundle_worktype';
    }
}
