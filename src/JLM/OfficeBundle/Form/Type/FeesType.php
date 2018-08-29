<?php
namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('frequence1', 'percent', ['required' => false, 'attr' => ['label' => 'Annuelle']])
            ->add('frequence2', 'percent', ['required' => false, 'attr' => ['label' => 'Semestrielle']])
            ->add('frequence4', 'percent', ['required' => false, 'attr' => ['label' => 'Trimestrielle']])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\OfficeBundle\Entity\FeesFollower']);
    }

    public function getName()
    {
        return 'fees';
    }
}
