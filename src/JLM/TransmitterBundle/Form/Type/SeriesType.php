<?php

namespace JLM\TransmitterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JLM\TransmitterBundle\Entity\UserGroupRepository;

class SeriesType extends AbstractType
{
	private $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$id = $this->id;
        $builder
        	->add('attribution','transmitter_attribution_hidden')
        	->add('userGroup','entity',array(
        			'class'=>'JLM\TransmitterBundle\Entity\UserGroup',
        			'label'=>'Groupe utilisateur',
        			'query_builder'=> function(UserGroupRepository $er) use ($id)
        			{
        				return $er->getFromSite($id);
        			},
        	))
        	->add('model','entity',array('class'=>'JLM\TransmitterBundle\Entity\Model','label'=>'Type d\'émetteurs'))
        	->add('quantity',null,array('label'=>'Nombre d\'émetteurs', 'attr'=>array('class'=>'input-mini','maxlength'=>3)))
            ->add('first',null,array('label'=>'Premier numéro', 'attr'=>array('class'=>'input-small','maxlength'=>6)))
            ->add('last',null,array('label'=>'Dernier numéro', 'attr'=>array('class'=>'input-small','maxlength'=>6)))
            ->add('guarantee',null,array('label'=>'Garantie','attr'=>array('placeholder'=>'MMAA','class'=>'input-mini','maxlength'=>4)))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\TransmitterBundle\Entity\Series',
        	'attr'=>array('class'=>'transmitter_series'),
        ));
    }

    public function getName()
    {
        return 'jlm_transmitterbundle_seriestype';
    }
}
