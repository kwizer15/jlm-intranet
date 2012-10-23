<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('lastName',null,array('label'=>'Nom'))
            ->add('firstName',null,array('label'=>'Prénom'))
            ->add('role')
            ->add('addresses','collection',array('label'=>'Adresses','type'=>new AddressType,'prototype' => true,'allow_add' => true))
            ->add('phones','collection',array('label'=>'Téléphones','type'=>new PhoneType,'prototype' => true,'allow_add' => true))
            ->add('emails','collection',array('label'=>'Emails','type'=>new EmailType,'prototype' => true,'allow_add' => true))
            ->add('companies',null,array('label'=>'Sociétés'))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_employeetype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ModelBundle\Entity\Employee',
    	);
    }
}
