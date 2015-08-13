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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SupplierPurchasePriceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('supplier',null,array('label'=>'Fournisseur')) // Typeahead
       		->add('reference',null,array('label'=>'Référence','attr'=>array('class'=>'input-small')))
			->add('unitPrice','money',array('label'=>'Prix d\'achat HT','grouping'=>true,'attr'=>array('class'=>'input-small')))
            ->add('discount','percent',array('type'=>'integer','label'=>'Remise fournisseur','attr'=>array('class'=>'input-mini')))
            ->add('expenseRatio','percent',array('type'=>'integer','label'=>'Frais','attr'=>array('class'=>'input-mini')))
            ->add('delivery','money',array('label'=>'Port','grouping'=>true,'attr'=>array('class'=>'input-mini')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_product_supplierpurchaseprice';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
        ->setDefaults(array(
            'data_class' => 'JLM\ProductBundle\Entity\SupplierPurchasePrice',
        ));
    }
}
