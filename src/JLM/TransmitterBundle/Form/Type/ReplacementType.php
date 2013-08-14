<?php

namespace JLM\TransmitterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JLM\TransmitterBundle\Entity\TransmitterRepository;

class ReplacementType extends AbstractType
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
        	->add('old','entity',array(
        			'class'=>'JLM\TransmitterBundle\Entity\Transmitter',
        			'label'=>'Ancien émetteur',
        			'query_builder'=> function(TransmitterRepository $er) use ($id)
        			{
        				return $er->getFromSite($id);
        			},
        	))
            ->add('newNumber',null,array('label'=>'Numéro du nouvel émetteur', 'attr'=>array('class'=>'input-small')))
            ->add('guarantee',null,array('label'=>'Garantie du nouvel émetteur', 'attr'=>array('class'=>'input-mini','placeholder'=>'MMAA')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\TransmitterBundle\Entity\Replacement',
        	'attr'=>array('class'=>'transmitter_replacement'),
        ));
    }

    public function getName()
    {
        return 'jlm_transmitterbundle_replacementtype';
    }
}
