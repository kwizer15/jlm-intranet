<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JLM\ModelBundle\Form\DataTransformer\CityToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CitySelectType extends AbstractType
{
//	/**
//	 * @var ObjectManager
//	 */
//	private $om;
//	
//	/**
//	 * @param ObjectManager $om
//	 */
//	public function __construct(ObjectManager $om)
//	{
//		$this->om = $om;
//	}
//	
//	/**
//	 * @param FormBuilderInterface $builder
//	 * @param array $options
//	 */
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//    	$transformer = new CityToStringTransformer($this->om);
//    	$builder->addModelTransformer($transformer);
//    	
//    }
//
    public function getParent()
    {
    	return 'genemu_jqueryselect2_hidden';
//    	return 'text';
    }
    
    public function getName()
    {
        return 'city_select';
    }

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
//            'invalid_message' => 'The selected city does not exist',
			'class' => 'JLM\ModelBundle\Entity\City'
        ));
    }
}
