<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\DailyBundle\Entity\Fixing;
use JLM\ModelBundle\Form\Type\DoorHiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FixingEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('door', DoorHiddenType::class)
            ->add('place', TextType::class, ['label' => 'Porte', 'attr' => ['class' => 'input-xlarge']])
            ->add(
                'askDate',
                DateTimeType::class,
                [
                    'label' => 'Date de la demande',
                    'date_widget' => 'single_text',
                    'date_format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'askMethod',
                TextType::class,
                ['label' => 'Méthode de la demande', 'attr' => ['class' => 'input-small']]
            )
            ->add(
                'reason',
                TextType::class,
                ['label' => 'Raison de l\'intervention', 'attr' => ['class' => 'input-xxlarge']]
            )
            ->add('contactName', TextType::class, ['label' => 'Nom du contact', 'required' => false])
            ->add('contactPhones', TextType::class, ['label' => 'Téléphones', 'required' => false])
            ->add(
                'contactEmail',
                EmailType::class,
                [
                    'label' => 'e-mail',
                    'required' => false,
                    'attr' => ['class' => 'input-xlarge'],
                ]
            )
            ->add(
                'priority',
                ChoiceType::class,
                [
                    'label' => 'Priorité',
                    'choices' => [
                        1 => 'TRES URGENT',
                        2 => 'Urgent',
                        3 => 'Haute',
                        4 => 'Normal',
                        5 => 'Basse',
                        6 => 'Très basse',
                    ],
                ]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Fixing::class,
                'attr' => ['class' => 'interventionForm'],
            ]
        );
    }
}
