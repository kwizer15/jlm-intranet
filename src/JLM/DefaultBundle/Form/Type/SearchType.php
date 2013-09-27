<?php

namespace JLM\DefaultBundle\Form\Type;

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
    			'data_class' => 'JLM\DefaultBundle\Entity\Search'
    	));
    }
    
    public function getName()
    {
        return 'jlm_default_search';
    }
}