<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecuperationEquipmentEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('begin', 'datetime', [
                                        'label'   => 'Début',
                                        'hours'   => [
                                                      8,
                                                      9,
                                                      10,
                                                      11,
                                                      12,
                                                      13,
                                                      14,
                                                      15,
                                                      16,
                                                      17,
                                                      18,
                                                     ],
                                        'minutes' => [
                                                      0,
                                                      5,
                                                      10,
                                                      15,
                                                      20,
                                                      25,
                                                      30,
                                                      35,
                                                      40,
                                                      45,
                                                      50,
                                                      55,
                                                     ],
                                       ])
            ->add('end', 'time', [
                                  'label'   => 'Fin',
                                  'hours'   => [
                                                8,
                                                9,
                                                10,
                                                11,
                                                12,
                                                13,
                                                14,
                                                15,
                                                16,
                                                17,
                                                18,
                                               ],
                                  'minutes' => [
                                                0,
                                                5,
                                                10,
                                                15,
                                                20,
                                                25,
                                                30,
                                                35,
                                                40,
                                                45,
                                                50,
                                                55,
                                               ],
                                 ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\DailyBundle\Entity\ShiftTechnician']);
    }

    public function getName()
    {
        return 'jlm_dailybundle_recuperationequipmentedittype';
    }
}
