<?php

namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\Common\Persistence\ObjectManager;

use JLM\ContactBundle\Form\DataTransformer\ContactToIntTransformer;



class HiddenContactType extends AbstractType
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
    	$transformer = new ContactToIntTransformer($this->om);
    	$builder->addModelTransformer($transformer);
    	
    }

    public function getParent()
    {
    	return 'hidden';
    }
    
    public function getName()
    {
        return 'hiddencontacttype';
    }
    
	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected contact does not exist',
        ));
    }
}