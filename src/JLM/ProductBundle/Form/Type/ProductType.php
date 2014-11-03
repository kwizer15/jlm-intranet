<?php

/*
 * This file is part of the JLMContactBundle package.
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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
       		->add('reference',null,array('label'=>'Référence','attr'=>array('class'=>'input-small')))
//          ->add('barcode',null,array('label'=>'Code barre','required'=>false,'attr'=>array('class'=>'input-xlarge')))
            ->add('category',null,array('label'=>'Famille de produit'))
            ->add('designation',null,array('label'=>'Designation','attr'=>array('class'=>'input-xxlarge')))
            ->add('description',null,array('label'=>'Description longue','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
            ->add('supplier',null,array('label'=>'Fournisseur')) // Typeahead
            ->add('unity',null,array('label'=>'Unité','attr'=>array('class'=>'input-small')))
			->add('purchase','money',array('label'=>'Prix d\'achat HT','grouping'=>true,'attr'=>array('class'=>'input-small')))
            ->add('discountSupplier','percent',array('type'=>'integer','label'=>'Remise fournisseur','attr'=>array('class'=>'input-mini')))
            ->add('expenseRatio','percent',array('type'=>'integer','label'=>'Frais','attr'=>array('class'=>'input-mini')))
            ->add('shipping','money',array('label'=>'Port','grouping'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('unitPrice','money',array('label'=>'PVHT','grouping'=>true,'attr'=>array('class'=>'input-mini')))
            
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_product_product';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
        ->setDefaults(array(
            'data_class' => 'JLM\ProductBundle\Entity\Product',
        ));
    }
}
