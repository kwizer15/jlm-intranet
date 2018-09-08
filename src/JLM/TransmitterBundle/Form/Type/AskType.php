<?php

namespace JLM\TransmitterBundle\Form\Type;

use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\ModelBundle\Form\Type\SiteSelectType;
use JLM\ModelBundle\Form\Type\TrusteeSelectType;
use JLM\TransmitterBundle\Entity\Ask;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation', DatepickerType::class, ['label' => 'Date de la demande'])
            ->add('trustee', TrusteeSelectType::class, ['label' => 'Syndic', 'attr' => ['class' => 'input-xlarge']])
            ->add(
                'site',
                SiteSelectType::class,
                ['label' => 'Affaire', 'attr' => ['class' => 'input-xxlarge', 'rows' => 5]]
            )
            ->add('method', TextType::class, ['label' => 'Arrivée par', 'attr' => ['class' => 'input-medium']])
            ->add('maturity', DatepickerType::class, ['label' => 'Date d\'échéance', 'required' => false])
            ->add('ask', TextType::class, ['label' => 'Demande', 'attr' => ['class' => 'input-xxlarge', 'rows' => 5]])
            ->add('file', TextType::class, ['label' => 'Fichier joint'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Ask::class,
                'attr' => ['class' => 'askForm'],
            ]
        );
    }
}
