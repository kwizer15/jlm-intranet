<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ContactBundle\Form\Type\PersonSelectType;
use JLM\ModelBundle\Entity\SiteContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', SiteSelectType::class, ['label' => 'Affaire', 'attr' => ['class' => 'input-xxlarge']])
            ->add('person', PersonSelectType::class, ['label' => 'Contact'])
            ->add('role', TextType::class, ['label' => 'Rôle du contact'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => SiteContact::class]);
    }
}
