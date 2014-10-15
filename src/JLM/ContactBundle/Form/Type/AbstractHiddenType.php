<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class AbstractHiddenType extends AbstractType
{
	/**
	 * @var ObjectManager
	 */
	private $om;
	
	/**
	 * @param ObjectManager $om
	 */
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$cl = $this->getTransformerClass();
    	$transformer = new $cl($this->om);
    	$builder->addModelTransformer($transformer);
    	
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
    	return 'hidden';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getTypeName().'_hidden';
    }
    
    /**
     * {@inheritdoc}
     */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected '.$this->getTypeName().' does not exist',
        ));
    }
    
    /**
     * Get the transformer class
     * 
     * @return string
     */
    abstract protected function getTransformerClass();
    
    /**
     * Get the type name
     * 
     * @return string
     */
    abstract protected function getTypeName();
}
