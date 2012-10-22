<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use JLM\ModelBundle\Form\DataTransformer\TrusteeToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrusteeSelectType extends AbstractType
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
	 * @param FormBuilder $builder
	 * @param array $options
	 */
    public function buildForm(FormBuilder $builder, array $options)
    {
    	$transformer = new TrusteeToStringTransformer($this->om);
    	$builder->prependClientTransformer($transformer);
    	
    }

    public function getParent(array $options)
    {
    	return 'text';
    }
    
    public function getName()
    {
        return 'trustee_select';
    }
    
	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected trustee does not exist',
        ));
    }
}
