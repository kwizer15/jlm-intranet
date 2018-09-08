<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\DailyBundle\Entity\ShiftTechnician;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ShiftingEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'begin',
                DateTimeType::class,
                [
                    'label' => 'Début',
                    'date_widget' => 'single_text',
                    'date_format' => 'dd/MM/yyyy',
                ]
            )
            ->add('end', TimeType::class, ['label' => 'Fin'])
            ->add(
                'comment',
                TextareaType::class,
                [
                    'label' => 'Commentaire',
                    'required' => false,
                    'attr' => ['class' => 'input-xlarge'],
                ]
            )
            ->get('end')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    $end = $event->getForm()->getData();
                    $begin = $event->getForm()->getParent()->get('begin')->getData();
                    $end->setDate($begin->format('Y'), $begin->format('m'), $begin->format('d'));
                }
            )
        ;;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ShiftTechnician::class]);
    }
}
