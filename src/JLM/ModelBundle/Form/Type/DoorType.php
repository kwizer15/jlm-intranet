<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('site','site_select',array('label'=>'Affaire','attr'=>array('class'=>'input-xxlarge')))
        	->add('location',null,array('label'=>'Localisation'))
        	->add('street',null,array('label'=>'Adresses d\'accès','required'=>false))
        	->add('type',null,array('label'=>'Type de porte'))
        	->add('width','distance',array('label'=>'Largeur','required'=>false))
        	->add('height','distance',array('label'=>'Hauteur','required'=>false))
        	->add('transmitters',null,array('label'=>'Type d\'emetteurs','required'=>false,'attr'=>array('class'=>'input-xlarge')))
        	->add('googlemaps',null,array('label'=>'Lien Google Maps','required'=>false,'attr'=>array('class'=>'input-xxlarge')))

        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortype';
    }
}
