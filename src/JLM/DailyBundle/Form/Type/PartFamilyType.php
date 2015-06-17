<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JLM\TransmitterBundle\Entity\UserGroupRepository;
use JLM\DailyBundle\Form\DataTransformer\PartFamilyToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class PartFamilyType extends AbstractType
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
    	$transformer = new PartFamilyToStringTransformer($this->om);
    	$builder->addModelTransformer($transformer);
    	
    }
    
    public function getParent()
    {
    	return 'text';
    }
    
    public function getName()
    {
    	return 'jlm_daily_partfamilytype';
    }
    
    /**
     * Ajoute l'option source
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setOptional(array('source'));
    }
    
    /**
     * Passe la source de données à la vue
     *
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    	$parts = $this->om->getRepository('JLMDailyBundle:PartFamily')->findAll();
    	$view->vars['source'] = $parts;
    }
}
