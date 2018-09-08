<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\DailyBundle\Entity\Fixing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FixingCloseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('published', CheckboxType::class, ['label' => 'Publier', 'required' => false])
            ->add(
                'partFamily',
                PartFamilyType::class,
                [
                    'label' => 'Famille de pièce',
                    'attr' => ['class' => 'input-large'],
                ]
            )
            ->add('due', TextType::class, ['label' => 'Cause', 'attr' => ['class' => 'input-large']])
            ->add('done', TextType::class, ['label' => 'Action', 'attr' => ['class' => 'input-large']])
            ->add('observation', TextType::class, ['label' => 'Constat', 'attr' => ['class' => 'input-xlarge']])
            ->add(
                'report',
                TextareaType::class,
                [
                    'label' => 'Action menée',
                    'required' => false,
                    'attr' => ['class' => 'input-xlarge'],
                ]
            )
            ->add(
                'rest',
                TextareaType::class,
                [
                    'label' => 'Reste à faire',
                    'required' => false,
                    'attr' => ['class' => 'input-xlarge'],
                ]
            )
            ->add(
                'voucher',
                TextType::class,
                [
                    'label' => 'Bon d\'intervention',
                    'required' => false,
                    'attr' => ['class' => 'input-small'],
                ]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => Fixing::class]);
    }
}
