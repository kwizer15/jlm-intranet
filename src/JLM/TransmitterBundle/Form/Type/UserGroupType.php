<?php

namespace JLM\TransmitterBundle\Form\Type;

use JLM\ModelBundle\Form\Type\SiteHiddenType;
use JLM\TransmitterBundle\Entity\UserGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', SiteHiddenType::class)
            ->add('name', TextType::class, ['label' => 'Nom du groupe'])
            ->add('model', TextType::class, ['label' => 'Type d\'émetteurs'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => UserGroup::class,
                'attr' => ['class' => 'usergroup'],
            ]
        );
    }
}
