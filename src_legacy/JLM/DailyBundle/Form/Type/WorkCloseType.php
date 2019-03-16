<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\DailyBundle\Entity\Work;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkCloseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('published', CheckboxType::class, ['label' => 'Publier', 'required' => false])
            ->add('report', TextareaType::class, ['label' => 'Rapport', 'attr' => ['class' => 'input-xlarge']])
            ->add(
                'rest',
                TextareaType::class,
                [
                 'label'    => 'Reste à faire',
                 'required' => false,
                 'attr'     => ['class' => 'input-xlarge'],
                ]
            )
            ->add(
                'voucher',
                TextType::class,
                [
                 'label'    => 'Bon d\'intervention',
                 'required' => false,
                 'attr'     => ['class' => 'input-small'],
                ]
            )
            ->add(
                'comments',
                TextareaType::class,
                [
                 'label'    => 'Commentaires',
                 'required' => false,
                 'attr'     => ['class' => 'input-xlarge'],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Work::class]);
    }
}
