<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FixingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('door','door_hidden')
        	->add('askDate','datetime',array(
      				'label'=>'Date de la demande',
        			'date_widget'=>'single_text',
        			'date_format'=>'dd/MM/yyyy',
      			))
      		->add('askMethod',null,array('label'=>'Méthode de la demande','attr'=>array('class'=>'input-small')))
        	->add('reason',null,array('label'=>'Raison de l\'intervention','attr'=>array('class'=>'input-xlarge')))
            ->add('contactName',null,array('label'=>'Nom du contact','required'=>false))
            ->add('contactPhones',null,array('label'=>'Téléphones','required'=>false))
            ->add('contactEmail','email',array('label'=>'e-mail','required'=>false,'attr'=>array('class'=>'input-xlarge')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\DailyBundle\Entity\Fixing',
        	'attr' => array('class'=>  'interventionForm'),
        ));
    }

    public function getName()
    {
        return 'jlm_dailybundle_fixingtype';
    }
}
