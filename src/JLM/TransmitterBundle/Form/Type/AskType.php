<?php

namespace JLM\TransmitterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation','datepicker',array('label'=>'Date de la demande'))
            ->add('trustee','trustee_select',array('label'=>'Syndic','attr'=>array('class'=>'input-xlarge')))
            ->add('site','site_select',array('label'=>'Affaire','attr'=>array('class'=>'input-xxlarge','rows'=>5)))
            ->add('method',null,array('label'=>'Arrivée par','attr'=>array('class'=>'input-medium')))
            ->add('maturity','datepicker',array('label'=>'Date d\'échéance','required'=>false))
            ->add('ask',null,array('label'=>'Demande','attr'=>array('class'=>'input-xxlarge','rows'=>5)))
            ->add('file',null,array('label'=>'Fichier joint'))
        //    ->add('person','site_contact',array('label'=>'Contact'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\TransmitterBundle\Entity\Ask',
        	'attr' => array('class'=>'askForm')
        ));
    }

    public function getName()
    {
        return 'jlm_transmitterbundle_asktype';
    }
}
