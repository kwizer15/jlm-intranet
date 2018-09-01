<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FixingCloseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('published', 'checkbox', ['label' => 'Publier', 'required' => false])
            ->add(
                'partFamily',
                'jlm_daily_partfamilytype',
                [
                 'label' => 'Famille de pièce',
                 'attr'  => ['class' => 'input-large'],
                ]
            )
            ->add('due', null, ['label' => 'Cause', 'attr' => ['class' => 'input-large']])
            ->add('done', null, ['label' => 'Action', 'attr' => ['class' => 'input-large']])
            ->add('observation', null, ['label' => 'Constat', 'attr' => ['class' => 'input-xlarge']])
            ->add(
                'report',
                'textarea',
                [
                 'label'    => 'Action menée',
                 'required' => false,
                 'attr'     => ['class' => 'input-xlarge'],
                ]
            )
            ->add(
                'rest',
                'textarea',
                [
                 'label'    => 'Reste à faire',
                 'required' => false,
                 'attr'     => ['class' => 'input-xlarge'],
                ]
            )
            ->add(
                'voucher',
                null,
                [
                 'label'    => 'Bon d\'intervention',
                 'required' => false,
                 'attr'     => ['class' => 'input-small'],
                ]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\DailyBundle\Entity\Fixing']);
    }

    public function getName()
    {
        return 'jlm_dailybundle_fixingclosetype';
    }
}
