<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TrusteeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {	
        $builder
            ->add('name',null,array('label'=>'Nom','attr'=>array('class'=>'input-large')))
            ->add('accession','choice',array('label'=>'Accession/Social','choices'=>array('1'=>'Accession','0'=>'Social'),'expanded'=>true,'multiple'=>false))
            ->add('accountNumber',null,array('label'=>'Numéro de compte','attr'=>array('class'=>'input-small')))

            ->add('address',new AddressType,array('label'=>'Adresse'))
            ->add('phone',null,array('label'=>'Téléphone','attr'=>array('class'=>'input-medium')))
            ->add('fax',null,array('label'=>'Fax','required'=>false,'attr'=>array('class'=>'input-medium')))
            ->add('email','email',array('label'=>'e-mail','required'=>false,'attr'=>array('class'=>'input-xlarge')))

        	->add('billingAddress',new AddressType,array('label'=>'Adresse de facturation','required'=>false)) // Petite case à cocher + Formulaire
        	->add('billingPhone',null,array('label'=>'Téléphone','required'=>false,'attr'=>array('class'=>'input-medium')))
            ->add('billingFax',null,array('label'=>'Fax','required'=>false,'attr'=>array('class'=>'input-medium')))
            ->add('billingEmail','email',array('label'=>'e-mail','required'=>false,'attr'=>array('class'=>'input-xlarge')))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_trusteetype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'JLM\ModelBundle\Entity\Trustee',
    	);
    }
}
