<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>'Nom'))
            ->add('address',new AddressType,array('label'=>'Adresse'))
            ->add('phone',null,array('label'=>'Téléphone'))
            ->add('fax',null,array('label'=>'Fax','required'=>false))
            ->add('email','email',array('label'=>'e-mail','required'=>false))
            ->add('website','url',array('label'=>'Site internet','required'=>false))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_suppliertype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ModelBundle\Entity\Supplier',
    	);
    }
}
