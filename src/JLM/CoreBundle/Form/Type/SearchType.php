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
        	->add('query','text',array('required'=>true,'attr'=>array('placeholder'=>'Recherche...')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    		'data_class' => 'JLM\CoreBundle\Entity\Search',
    		'method' => 'GET',
    	   // 'attr' => array('class' => 'navbar-form navbar-left', 'role'=>'search'),
    		'csrf_protection'   => false,
    	));
    }
    
    public function getName()
    {
        return 'jlm_core_search';
    }
}