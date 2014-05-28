<?php
namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskQuoteType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('creation','datepicker',array('label'=>'Date de la demande'))
			->add('trustee','trustee_select',array('label'=>'Syndic'))
			->add('site','site_select',array('label'=>'Affaire','attr'=>array('class'=>'input-xxlarge','rows'=>5)))
			->add('door','entity',array('class'=>'JLM\ModelBundle\Entity\Door','empty_value' => 'Affaire complète','label'=>'Installation','attr'=>array('class'=>'input-xxlarge'),'required'=>false))
			->add('method',null,array('label'=>'Arrivée par','attr'=>array('class'=>'input-medium')))
			->add('maturity','datepicker',array('label'=>'Date d\'échéance','required'=>false))
			->add('ask',null,array('label'=>'Demande','attr'=>array('class'=>'input-xxlarge','rows'=>5)))
			->add('file',null,array('label'=>'Fichier joint'))
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