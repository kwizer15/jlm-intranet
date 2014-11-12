<?php
namespace JLM\FeeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FeeType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('trustee','trustee_select',array('label'=>'Syndic','attr'=>array('class'=>'input-xlarge')))
		->add('address',null ,array('label'=>'Adresse','attr'=>array('class'=>'input-xlarge')))
		->add('prelabel',null,array('label'=>'Libélé','attr'=>array('class'=>'input-xlarge')))
		->add('frequence','choice',array('label'=>'Fréquence','choices'=>array(1=>'Annuelle',2=>'Semestrielle',4=>'Trimestrielle'),'attr'=>array('class'=>'input-normal')))
		->add('vat','entity',array('label'=>'TVA','class'=>'JLM\CommerceBundle\Model\VATInterface','attr'=>array('class'=>'input-small')))
		->add('contracts','collection',array('prototype'=>true,'allow_add'=>true,'allow_delete'=>true,'type'=>'contract_select','label'=>'Contrats'));
		
		;
	}

	public function getName()
	{
		return 'fee';
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'JLM\FeeBundle\Entity\Fee',
		);
	}
}