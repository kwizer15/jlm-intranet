<?php

namespace JLM\TransmitterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JLM\TransmitterBundle\Entity\UserGroupRepository;

class SeriesType extends AbstractType
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->id;
        $builder
            ->add('attribution', 'transmitter_attribution_hidden')
            ->add(
                'userGroup',
                'entity',
                [
                    'class' => 'JLM\TransmitterBundle\Entity\UserGroup',
                    'label' => 'Groupe utilisateur',
                    'query_builder' => function (UserGroupRepository $er) use ($id) {
                        return $er->getFromSite($id);
                    },
                    'empty_value' => 'Choisissez...',
                ]
            )
            ->add(
                'model',
                'entity',
                [
                    'class' => 'JLM\TransmitterBundle\Entity\Model',
                    'label' => 'Type d\'émetteurs',
                    'empty_value' => 'Choisissez...',
                ]
            )
            ->add(
                'quantity',
                null,
                ['label' => 'Nombre d\'émetteurs', 'attr' => ['class' => 'input-mini', 'maxlength' => 3]]
            )
            ->add('first', null, ['label' => 'Premier numéro', 'attr' => ['class' => 'input-small', 'maxlength' => 6]])
            ->add('last', null, ['label' => 'Dernier numéro', 'attr' => ['class' => 'input-small', 'maxlength' => 6]])
            ->add(
                'guarantee',
                null,
                ['label' => 'Garantie', 'attr' => ['placeholder' => 'MMAA', 'class' => 'input-mini', 'maxlength' => 4]]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'JLM\TransmitterBundle\Entity\Series',
                'attr' => ['class' => 'transmitter_series'],
            ]
        );
    }

    public function getName()
    {
        return 'jlm_transmitterbundle_seriestype';
    }
}
