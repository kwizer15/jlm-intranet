<?php
namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AskDontTreatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dontTreat', null, ['label'=>'Raison du non-traitement','attr'=>['class'=>'input-xlarge','rows'=>5]])
        ;
    }
}
