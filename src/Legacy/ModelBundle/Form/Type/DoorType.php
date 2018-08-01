<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('site','genemu_jqueryselect2_entity',array('label'=>'Affaire','class'=>'JLM\ModelBundle\Entity\Site','attr'=>array('class'=>'input-xxlarge')))
        	->add('location',null,array('label'=>'Localisation'))
        	->add('street',null,array('label'=>'Adresses d\'accès','required'=>false))
			->add('billingPrelabel',null,array('label'=>'Libélé de facturation', 'required'=>false))
			->add('model', null, array('label'=>'Modèle de porte'))
			->add('ceNumber', null, array('label'=>'Identification CE'))
        	->add('type',null,array('label'=>'Type de porte'))
        	->add('width','distance',array('label'=>'Largeur','required'=>false))
        	->add('height','distance',array('label'=>'Hauteur','required'=>false))
        	->add('transmitters',null,array('label'=>'Type d\'emetteurs','required'=>false,'attr'=>array('class'=>'input-xlarge')))
        	->add('observations',null,array('label'=>'Observations','required'=>false,'attr'=>array('class'=>'input-large')))
        	->add('latitude',null,array('label'=>'Latitude','required'=>false,'precision'=>7,'attr'=>array('class'=>'input-large'))) // Précision
        	->add('longitude',null,array('label'=>'Latitude','required'=>false,'precision'=>7,'attr'=>array('class'=>'input-large'))) // Précision
        	->add('googlemaps',null,array('label'=>'Lien Google Maps','required'=>false,'attr'=>array('class'=>'input-xxlarge')))

        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortype';
    }
}
