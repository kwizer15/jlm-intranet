<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WorkCloseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('published', 'checkbox', ['label' => 'Publier', 'required' => false])
            ->add('report', 'textarea', ['label' => 'Rapport', 'attr' => ['class' => 'input-xlarge']])
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
            ->add(
                'comments',
                'textarea',
                [
                 'label'    => 'Commentaires',
                 'required' => false,
                 'attr'     => ['class' => 'input-xlarge'],
                ]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\DailyBundle\Entity\Work']);
    }

    public function getName()
    {
        return 'jlm_dailybundle_workclosetype';
    }
}
