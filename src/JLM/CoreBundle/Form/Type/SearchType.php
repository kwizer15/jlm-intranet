<?php

namespace JLM\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('query','text',array('required'=>true,'attr'=>array('placeholder'=>'Recherche...','class'=>'search-query input-medium')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    		'data_class' => 'JLM\CoreBundle\Entity\Search',
    		'method' => 'GET',
    		'csrf_protection'   => false,
    	));
    }
    
    public function getName()
    {
        return 'jlm_core_search';
    }
}