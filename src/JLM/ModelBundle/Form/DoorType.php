<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('site','site_select',array('label'=>'Affaire','attr'=>array('class'=>'input-xxlarge')))
        	->add('type',null,array('label'=>'Type de porte'))
        	->add('street',null,array('label'=>'Adresse','required'=>false))
        	->add('location',null,array('label'=>'Localisation'))
        	->add('transmitters',null,array('label'=>'Emetteurs','attr'=>array('class'=>'input-xlarge')))
        	->add('googlemaps',null,array('label'=>'Lien Google Maps','required'=>false,'attr'=>array('class'=>'input-xxlarge')))

        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortype';
    }
}
