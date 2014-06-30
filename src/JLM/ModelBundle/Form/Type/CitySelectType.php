<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JLM\ModelBundle\Form\DataTransformer\CityToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CitySelectType extends AbstractType
{
    public function getParent()
    {
    	return 'genemu_jqueryselect2_hidden';
    }
    
    public function getName()
    {
        return 'city_select';
    }

	public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
			'data_class' => 'JLM\ModelBundle\Entity\City'
        ));
    }
}
