<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ShiftingEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('begin', 'datetime', [
                    'label'=>'Début',
                    'date_widget'=>'single_text',
                    'date_format'=>'dd/MM/yyyy',
                ])
            ->add('end', 'time', [
                    'label'=>'Fin',
                ])
            ->add('comment', 'textarea', [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => [
                    'class'=>'input-xlarge'
                    ]
                ])
            ->get('end')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                        $end = $event->getForm()->getData();
                        $begin = $event->getForm()->getParent()->get('begin')->getData();
                        $end->setDate($begin->format('Y'), $begin->format('m'), $begin->format('d'));
                }
            );
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'JLM\DailyBundle\Entity\ShiftTechnician',
        ]);
    }

    public function getName()
    {
        return 'jlm_dailybundle_shiftingedittype';
    }
}
