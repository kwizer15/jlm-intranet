<?php
namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeesType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('frequence1','percent',array('required'=>false,'attr'=>array('label'=>'Annuelle')))
			->add('frequence2','percent',array('required'=>false,'attr'=>array('label'=>'Semestrielle')))
			->add('frequence4','percent',array('required'=>false,'attr'=>array('label'=>'Trimestrielle')))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\OfficeBundle\Entity\FeesFollower'
		));
	}

	public function getName()
	{
		return 'fees';
	}
}