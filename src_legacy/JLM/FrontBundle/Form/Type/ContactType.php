<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Form\Type;

use JLM\FrontBundle\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactType extends AbstractType
{
    /**
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('subject', TextType::class);
        $builder->add('content', TextareaType::class);
        $builder->add('company', TextType::class, ['required' => false]);
        $builder->add('firstName', TextType::class, ['required' => false]);
        $builder->add('lastName', TextType::class);
        $builder->add('address', TextType::class, ['required' => false]);
        $builder->add('zip', TextType::class);
        $builder->add('city', TextType::class);
        $builder->add('country', TextType::class, ['required' => false]);
        $builder->add('phone', TextType::class);
        $builder->add('email', TextType::class);
    }

    /**
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Contact::class]);
    }
}
