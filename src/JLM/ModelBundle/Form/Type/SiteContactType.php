<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', 'site_select', ['label' => 'Affaire', 'attr' => ['class' => 'input-xxlarge']])
            ->add('person', 'jlm_contact_person_select', ['label' => 'Contact'])
            ->add('role', null, ['label' => 'Rôle du contact'])
            //  ->add('professionnalPhone',null,array('label'=>'Téléphone pro','required'=>false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\ModelBundle\Entity\SiteContact']);
    }

    public function getName()
    {
        return 'jlm_modelbundle_sitecontacttype';
    }
}
