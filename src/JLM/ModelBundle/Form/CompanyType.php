<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>'Nom'))
            ->add('addresses','collection',array('label'=>'Adresses','type'=>new AddressType))
            ->add('phones','collection',array('label'=>'Téléphones','type'=>new PhoneType))
            ->add('emails','collection',array('label'=>'Emails','type'=>new EmailType))
            ->add('employees','collection',array('label'=>'Contacts','type'=>new EmployeeCollectionType))
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
