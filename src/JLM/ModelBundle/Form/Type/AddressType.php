<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street',null,array('label'=>'Adresse','attr'=>array('placeholder'=>'Adresse','class'=>'input-xlarge')))
            ->add('city','city_select' ,array('label'=>'Ville','attr'=>array('placeholder'=>'Ville','class'=>'input-xlarge'))); 
        ;
    }

    public function getName()
    {
        return 'address';
    }
    
	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver
    		->setDefaults(array(
            	'data_class' => 'JLM\ModelBundle\Entity\Address',
        ));
    }
}
