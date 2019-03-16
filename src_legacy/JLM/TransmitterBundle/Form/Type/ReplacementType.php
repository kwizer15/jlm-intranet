<?php

namespace JLM\TransmitterBundle\Form\Type;

use JLM\TransmitterBundle\Entity\Replacement;
use JLM\TransmitterBundle\Entity\Transmitter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JLM\TransmitterBundle\Entity\TransmitterRepository;

class ReplacementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attribution', AttributionHiddenType::class)
            ->add(
                'old',
                EntityType::class,
                [
                    'class' => Transmitter::class,
                    'label' => 'Ancien émetteur',
                    'query_builder' => function (TransmitterRepository $er) use ($options) {
                        return $er->getFromSite($options['siteId']);
                    },
                ]
            )
            ->add(
                'newNumber',
                TextType::class,
                ['label' => 'Numéro du nouvel émetteur', 'attr' => ['class' => 'input-small']]
            )
            ->add(
                'guarantee',
                TextType::class,
                ['label' => 'Garantie du nouvel émetteur', 'attr' => ['class' => 'input-mini', 'placeholder' => 'MMAA']]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Replacement::class,
                'attr' => ['class' => 'transmitter_replacement'],
                'siteId' => null,
            ]
        );
    }
}
