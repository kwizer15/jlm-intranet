<?php

namespace JLM\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use JLM\ContactBundle\Form\Type\ContactSelectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contact', ContactSelectType::class, ['label' => 'Contact', 'attr' => ['class' => 'input-large']])
            ->add(
                'roles',
                CollectionType::class,
                [
                    'entry_type' => ChoiceType::class,
                    'options' => [
                        'choices' => array_flip([
                            'ROLE_MANAGER' => 'Syndic',
                            'ROLE_BUSINESS' => 'Copro',
                        ]),
                        'choices_as_values' => true,
                        'required' => true,
                        'empty_value' => 'Choisir le role',
                        'empty_data' => null,
                    ],
                ]
            )
        ;
    }

    public function getParent(): string
    {
        return RegistrationFormType::class;
    }
}
