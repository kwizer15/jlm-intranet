<?php

namespace JLM\TransmitterBundle\Form\Type;

use JLM\TransmitterBundle\Entity\Transmitter;
use JLM\TransmitterBundle\Entity\UserGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JLM\TransmitterBundle\Entity\UserGroupRepository;

class TransmitterType extends AbstractType
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
            ->add('model', TextType::class, ['label' => 'Type d\'émetteur', 'empty_value' => 'Choisissez...'])
            ->add('number', TextType::class, ['label' => 'Numéro', 'attr' => ['class' => 'input-small']])
            ->add(
                'guarantee',
                TextType::class,
                ['label' => 'Garantie', 'attr' => ['class' => 'input-mini', 'placeholder' => 'MMAA']]
            )
            ->add('userName', TextType::class, ['label' => 'Utilisateur', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Transmitter::class,
                'attr' => ['class' => 'transmitter'],
            ]
        );
    }
}
