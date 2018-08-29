<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FixingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('door', 'door_hidden')
            ->add('askDate', 'datetime', [
                                          'label'       => 'Date de la demande',
                                          'date_widget' => 'single_text',
                                          'date_format' => 'dd/MM/yyyy',
                                         ])
            ->add('askMethod', null, ['label' => 'Méthode de la demande', 'attr' => ['class' => 'input-small']])
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
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                                'data_class' => 'JLM\DailyBundle\Entity\Fixing',
                                'attr'       => ['class' => 'interventionForm'],
                               ]);
    }

    public function getName()
    {
        return 'jlm_dailybundle_fixingtype';
    }
}
