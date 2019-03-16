<?php

namespace JLM\ModelBundle\Form\Type;

use Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2EntityType;
use Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2Type;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\TransmitterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DoorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'site',
                Select2EntityType::class,
                ['label' => 'Affaire', 'class' => Site::class, 'attr' => ['class' => 'input-xxlarge']]
            )
            ->add('location', TextType::class, ['label' => 'Localisation'])
            ->add('street', TextType::class, ['label' => 'Adresses d\'accès', 'required' => false])
            ->add('billingPrelabel', TextType::class, ['label' => 'Libélé de facturation', 'required' => false])
            ->add('model', TextType::class, ['label' => 'Modèle de porte'])
            ->add('ceNumber', TextType::class, ['label' => 'Identification CE'])
            ->add('type', TextType::class, ['label' => 'Type de porte'])
            // ->add('width', DistanceType::class, ['label' => 'Largeur', 'required' => false])
            // ->add('height', DistanceType::class, ['label' => 'Hauteur', 'required' => false])
            ->add(
                'transmitters',
                EntityType::class,
                [
                    'label' => 'Type d\'emetteurs',
                    'class' => TransmitterType::class,
                    'multiple' => true,
                    'required' => false,
                    'attr' => ['class' => 'input-xlarge'],
                ]
            )
            ->add(
                'observations',
                TextType::class,
                ['label' => 'Observations', 'required' => false, 'attr' => ['class' => 'input-large']]
            )
            ->add(
                'latitude',
                NumberType::class,
                ['label' => 'Latitude', 'required' => false, 'scale' => 7, 'attr' => ['class' => 'input-large']]
            )
            ->add(
                'longitude',
                NumberType::class,
                ['label' => 'Latitude', 'required' => false, 'scale' => 7, 'attr' => ['class' => 'input-large']]
            )
            ->add(
                'googlemaps',
                TextType::class,
                ['label' => 'Lien Google Maps', 'required' => false, 'attr' => ['class' => 'input-xxlarge']]
            )
        ;
    }
}
