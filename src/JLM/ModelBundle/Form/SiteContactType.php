<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('site','site_select',array('label'=>'Affaire','attr'=>array('class'=>'input-xxlarge')))
        	->add('role',null,array('label'=>'Rôle du contact','required'=>false))
        	->add('person',new PersonType,array('label'=>'Contact'))
        	->add('professionnalPhone',null,array('label'=>'Téléphone pro','required'=>false))  
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\ModelBundle\Entity\SiteContact'
        ));
    }

    public function getName()
    {
        return 'jlm_modelbundle_sitecontacttype';
    }
}
