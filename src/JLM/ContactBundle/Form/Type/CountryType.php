<?php
namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use JLM\ContactBundle\Entity\Country;

class CountryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('code',null,array('label'=>'Code','attr'=>array('class'=>'input-small')))
			->add('name',null,array('label'=>'Nom'))
		;
	}

	public function getName()
	{
		return 'jlm_contactbundle_countrytype';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
				'data_class' => 'JLM\ContactBundle\Entity\Country',
				'empty_data' => function (FormInterface $form) {
					$datas = $form->getData();
					return new Country($datas['code'],$datas['name']);
				},
		));
	}
}
