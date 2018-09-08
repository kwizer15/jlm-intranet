<?php

namespace JLM\TransmitterBundle\Form\Type;

use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\TransmitterBundle\Entity\Attribution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AttributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ask', AskHiddenType::class)
            ->add('creation', DatepickerType::class, ['label' => 'Date'])
            ->add('contact', TextType::class)
            ->add('individual', TextType::class, ['label' => 'Particulier', 'required' => false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => Attribution::class]);
    }
}
