<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        	->add('title','choice',array('label'=>'Titre','choices'=>array('M.','Mme','Mlle')))
        	->add('lastName',null,array('label'=>'Nom'))
            ->add('firstName',null,array('label'=>'Prénom','required'=>false))      
            ->add('role',null,array('label'=>'Rôle','required'=>false))
            ->add('fixedPhone',null,array('label'=>'Téléphone fixe','required'=>false))
            ->add('mobilePhone',null,array('label'=>'Téléphone mobile','required'=>false))
            ->add('professionnalPhone',null,array('label'=>'Téléphone professionnel','required'=>false))
            ->add('fax',null,array('label'=>'Fax','required'=>false))
            ->add('email','email',array('label'=>'Adresse e-mail','required'=>false))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_persontype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ModelBundle\Entity\Person',
    	);
    }
}
