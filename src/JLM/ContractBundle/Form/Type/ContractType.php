<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('door','door_hidden')
        	->add('trustee','trustee_select',array('label'=>'Syndic'))
            ->add('number',null,array('label'=>'Numéro'))
            ->add('complete','choice',array('label'=>'Type','choices'=>array('0'=>'Normal','1'=>'Complet')))
            ->add('option','choice',array('label'=>'Option','choices'=>array('0'=>'24/24h 7/7j','1'=>'8h30-17h30 du lundi au vendredi')))
            ->add('begin','datepicker',array('label'=>'Début du contrat'))		
            ->add('endWarranty','datepicker',array('label'=>'Fin de garantie','required'=>false))           
            ->add('fee','money',array('label'=>'Redevance annuelle','grouping'=>true))
            
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_contract_contract';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\ContractBundle\Entity\Contract',
        ));
    }
}
