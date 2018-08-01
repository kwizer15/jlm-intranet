<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactType extends AbstractType
{
	/**
	 * 
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('subject', 'text');
        $builder->add('content','textarea');
        $builder->add('company','text', array('required' => false));
        $builder->add('firstName','text', array('required' => false));
        $builder->add('lastName','text');
        $builder->add('address','text', array('required' => false));
        $builder->add('zip','text');
        $builder->add('city','text');
        $builder->add('country','text', array('required' => false));
        $builder->add('phone','text');
        $builder->add('email','text');
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return 'jlm_front_contacttype';
    }
    
    /**
     * 
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\FrontBundle\Entity\Contact',
    	));
    }
}