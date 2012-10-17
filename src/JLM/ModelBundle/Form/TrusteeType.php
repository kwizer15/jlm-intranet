<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TrusteeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>'Nom'))
            ->add('accession','choice',array('label'=>'Accession/Social','choices'=>array('1'=>'Accession','0'=>'Social'),'expanded'=>true,'multiple'=>false))
            ->add('accountNumber',null,array('label'=>'Numéro de compte'))
            ->add('addresses','collection',array('type'=>new AddressType))
            ->add('phones','collection',array('type'=>new PhoneType))
            ->add('emails','collection',array('type'=>new EmailType))
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
