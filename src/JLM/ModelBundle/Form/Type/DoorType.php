<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', 'genemu_jqueryselect2_entity', ['label'=>'Affaire','class'=>'JLM\ModelBundle\Entity\Site','attr'=>['class'=>'input-xxlarge']])
            ->add('location', null, ['label'=>'Localisation'])
            ->add('street', null, ['label'=>'Adresses d\'accès','required'=>false])
            ->add('billingPrelabel', null, ['label'=>'Libélé de facturation', 'required'=>false])
            ->add('model', null, ['label'=>'Modèle de porte'])
            ->add('ceNumber', null, ['label'=>'Identification CE'])
            ->add('type', null, ['label'=>'Type de porte'])
            ->add('width', 'distance', ['label'=>'Largeur','required'=>false])
            ->add('height', 'distance', ['label'=>'Hauteur','required'=>false])
            ->add('transmitters', null, ['label'=>'Type d\'emetteurs','required'=>false,'attr'=>['class'=>'input-xlarge']])
            ->add('observations', null, ['label'=>'Observations','required'=>false,'attr'=>['class'=>'input-large']])
            ->add('latitude', null, ['label'=>'Latitude','required'=>false,'precision'=>7,'attr'=>['class'=>'input-large']]) // Précision
            ->add('longitude', null, ['label'=>'Latitude','required'=>false,'precision'=>7,'attr'=>['class'=>'input-large']]) // Précision
            ->add('googlemaps', null, ['label'=>'Lien Google Maps','required'=>false,'attr'=>['class'=>'input-xxlarge']])

        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_doortype';
    }
}
