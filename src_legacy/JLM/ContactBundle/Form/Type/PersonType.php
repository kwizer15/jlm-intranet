<?php

namespace JLM\ContactBundle\Form\Type;

use JLM\ContactBundle\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                ChoiceType::class,
                [
                    'label' => 'Titre',
                    'choices' => [
                        'M.' => 'M.',
                        'Mme' => 'Mme',
                        'Mlle' => 'Mlle'
                    ],
                    'choices_as_values' => true,
                ]
            )
            ->add('lastName', TextType::class, ['label' => 'Nom'])
            ->add('firstName', TextType::class, ['label' => 'Prénom', 'required' => false])
            ->add('contact', ContactType::class, ['data_class' => Person::class])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults(
                [
                    'data_class' => Person::class,
                    'label' => 'Personne',
                ]
            );
    }
}
