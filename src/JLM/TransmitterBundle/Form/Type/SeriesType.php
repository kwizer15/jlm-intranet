<?php

namespace JLM\TransmitterBundle\Form\Type;

use JLM\TransmitterBundle\Entity\Model;
use JLM\TransmitterBundle\Entity\Series;
use JLM\TransmitterBundle\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('attribution', AttributionHiddenType::class)
            ->add(
                'userGroup',
                EntityType::class,
                [
                    'class' => UserGroup::class,
                    'label' => 'Groupe utilisateur',
                    'query_builder' => function (UserGroupRepository $er) use ($id) {
                        return $er->getFromSite($id);
                    },
                    'empty_value' => 'Choisissez...',
                ]
            )
            ->add(
                'model',
                EntityType::class,
                [
                    'class' => Model::class,
                    'label' => 'Type d\'émetteurs',
                    'empty_value' => 'Choisissez...',
                ]
            )
            ->add(
                'quantity',
                TextType::class,
                ['label' => 'Nombre d\'émetteurs', 'attr' => ['class' => 'input-mini', 'maxlength' => 3]]
            )
            ->add(
                'first',
                TextType::class,
                ['label' => 'Premier numéro', 'attr' => ['class' => 'input-small', 'maxlength' => 6]]
            )
            ->add(
                'last',
                TextType::class,
                ['label' => 'Dernier numéro', 'attr' => ['class' => 'input-small', 'maxlength' => 6]]
            )
            ->add(
                'guarantee',
                TextType::class,
                ['label' => 'Garantie', 'attr' => ['placeholder' => 'MMAA', 'class' => 'input-mini', 'maxlength' => 4]]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Series::class,
                'attr' => ['class' => 'transmitter_series'],
            ]
        );
    }
}
