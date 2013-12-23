<?php
namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JLM\ContactBundle\Model\PhoneRuleInterface;
use JLM\ContactBundle\Entity\ContactPhone;

class ContactPhoneType extends AbstractType
{
	/**
	 * Rule
	 * @var PhoneRuleInterface
	 */
	private $rule;
	
	/**
	 * Constructor
	 * @param PhoneRuleInterface $rule
	 */
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
				->add('contact','hiddencontacttype',array('required'=>true))
				->add('alias',null,array('label'=>'Nom de l\'adresse','required'=>true,'attr'=>array('class'=>'input-xlarge')))
				->add('phone',new PhoneType($this->rule),array('label'=>'Téléphone','required'=>true,'attr'=>array('class'=>'input-xlarge')))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'jlm_contactbundle_contactphonetype';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\ContactBundle\Entity\ContactEmail',
				'empty_data' => function (FormInterface $form) {
					$datas = $form->getData();
					return new ContactPhone($form->get('contact')->getData(), $form->get('alias')->getData(), $form->get('phone')->getData());
				}
		));
	}
}