<?php

/*
 * This file is part of the JLMProductBundle package.
*
* (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace JLM\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JLM\ContactBundle\Form\Type\AddressType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SupplierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>'Nom'))
            ->add('address',new AddressType,array('label'=>'Adresse'))
            ->add('phone',null,array('label'=>'Téléphone'))
            ->add('fax',null,array('label'=>'Fax','required'=>false))
            ->add('email','email',array('label'=>'e-mail','required'=>false))
            ->add('website','url',array('label'=>'Site internet','required'=>false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_product_supplier';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
    	    array(
    			'data_class' => 'JLM\ProductBundle\Entity\Supplier',
    	));
    }
}
