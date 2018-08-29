<?php

namespace JLM\TransmitterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation', 'datepicker', ['label' => 'Date de la demande'])
            ->add('trustee', 'trustee_select', ['label' => 'Syndic', 'attr' => ['class' => 'input-xlarge']])
            ->add('site', 'site_select', ['label' => 'Affaire', 'attr' => ['class' => 'input-xxlarge', 'rows' => 5]])
            ->add('method', null, ['label' => 'Arrivée par', 'attr' => ['class' => 'input-medium']])
            ->add('maturity', 'datepicker', ['label' => 'Date d\'échéance', 'required' => false])
            ->add('ask', null, ['label' => 'Demande', 'attr' => ['class' => 'input-xxlarge', 'rows' => 5]])
            ->add('file', null, ['label' => 'Fichier joint'])
        //    ->add('person','site_contact',array('label'=>'Contact'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                                'data_class' => 'JLM\TransmitterBundle\Entity\Ask',
                                'attr'       => ['class' => 'askForm'],
                               ]);
    }

    public function getName()
    {
        return 'jlm_transmitterbundle_asktype';
    }
}
