<?php
namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JLM\ContactBundle\Entity\Phone;
use JLM\ContactBundle\Model\PhoneRuleInterface;

class PhoneType extends AbstractType
{
	/**
	 * 
	 * @var PhoneRuleInterface
	 */
	private $rule;
	
	public function __construct(PhoneRuleInterface $rule)
	{
		$this->rule = $rule;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('number',null,array('label'=>'Numero','attr'=>array('class'=>'input-medium')))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'jlm_contactbundle_phonetype';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
				'data_class' => 'JLM\ContactBundle\Entity\Phone',
        		'empty_data' => new Phone($this->rule),
				
		));
	}
}
