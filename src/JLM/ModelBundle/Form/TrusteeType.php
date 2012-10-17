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
            ->add('addresses','collection',array('label'=>'Adresses','type'=>new AddressType,'prototype'=>true,'allow_add'=>true))
            ->add('phones','collection',array('label'=>'Téléphones','type'=>new PhoneType,'prototype'=>true,'allow_add'=>true))
            ->add('emails','collection',array('label'=>'E-mails','type'=>new EmailType,'prototype'=>true,'allow_add'=>true))
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
