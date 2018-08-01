<?php
namespace JLM\TransmitterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskDontTreatType extends \JLM\OfficeBundle\Form\Type\AskDontTreatType
{	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'JLM\TransmitterBundle\Entity\Ask'
		));
	}
	
	public function getName()
	{
		return 'jlm_transmitterbundle_askdonttreattype';
	}
}