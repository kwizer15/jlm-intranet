<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>'Nom'))
            ->add('address',new AddressType,array('label'=>'Adresse'))
            ->add('phone',null,array('label'=>'Téléphone'))
            ->add('fax',null,array('label'=>'Fax','required'=>false))
            ->add('email','email',array('label'=>'Email','required'=>false))
         //   ->add('contacts','collection',array('label'=>'Contacts','type'=>new EmployeeCollectionType))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_companytype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ModelBundle\Entity\Company',
    	);
    }
}
