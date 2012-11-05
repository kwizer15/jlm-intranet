<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('trustee','trustee_select',array('label'=>'Syndic'))
            ->add('address','address',array('label'=>'Adresse'))
            ->add('accession','choice',array('label'=>'Accession/Social','choices'=>array('1'=>'Accession','0'=>'Social'),'expanded'=>true,'multiple'=>false))
            ->add('vat',null,array('label'=>'TVA'))    
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\ModelBundle\Entity\Site'
        ));
    }

    public function getName()
    {
        return 'jlm_modelbundle_sitetype';
    }
}
