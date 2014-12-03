<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrusteeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {	
        $builder
            ->add('contact','jlm_contact_contact_select',array('label'=>'Contact','attr'=>array('class'=>'input-large')))

            ->add('accountNumber',null,array('label'=>'Numéro de compte','required'=>false,'attr'=>array('class'=>'input-small')))
            ->add('billingLabel',null,array('label'=>'Libélé de facturation','required'=>false))
        	->add('billingAddress','jlm_contact_address',array('label'=>'Adresse de facturation','required'=>false)) // Petite case à cocher + Formulaire
        	->add('billingPhone',null,array('label'=>'Téléphone','required'=>false,'attr'=>array('class'=>'input-medium')))
            ->add('billingFax',null,array('label'=>'Fax','required'=>false,'attr'=>array('class'=>'input-medium')))
            ->add('billingEmail','email',array('label'=>'e-mail','required'=>false,'attr'=>array('class'=>'input-xlarge')))
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_trusteetype';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver
    	->setDefaults(array(
    			'data_class' => 'JLM\ModelBundle\Entity\Trustee',
    	));
    }
}
