<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Form\Type;

use JLM\ContactBundle\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PersonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                'choice',
                ['label' => 'Titre', 'choices' => ['M.' => 'M.', 'Mme' => 'Mme', 'Mlle' => 'Mlle']]
            )
            ->add('lastName', null, ['label' => 'Nom'])
            ->add('firstName', null, ['label' => 'Prénom', 'required' => false])
            ->add('contact', ContactType::class, ['data_class' => Person::class])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
