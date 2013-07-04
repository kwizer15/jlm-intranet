<?php
namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskQuoteDontTreatType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('dontTreat',null,array('label'=>'Raison du non-traitement','attr'=>array('class'=>'input-xlarge','rows'=>5)))
		;
	}
		
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\OfficeBundle\Entity\AskQuote'
    	));
    }
		
    public function getName()
	{
		return 'askquote';
	}
}