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
        	->add('priority','hidden')
        	->add('supplier',null,array('attr'=>array('class'=>'input-small'))) // Typeahead
       		->add('reference',null,array('attr'=>array('class'=>'input-mini')))
			->add('publicPrice','money',array('grouping'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('discount','percent',array('mapped'=>false,'attr'=>array('class'=>'input-mini')))
            //->add('discountAmount','money',array('mapped'=>false, 'label'=>'Montant remise','attr'=>array('class'=>'input-mini')))
            ->add('unitPrice','money',array('grouping'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('expenseRatio','percent',array('mapped'=>false,'attr'=>array('class'=>'input-mini')))
            ->add('expense','money',array('grouping'=>true,'disabled'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('delivery','money',array('grouping'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('totalPrice','money',array('mapped'=>false,'grouping'=>true,'disabled'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('coeficient','percent',array('mapped'=>false,'attr'=>array('class'=>'input-mini')))
            ->add('margin','money',array('mapped'=>false,'grouping'=>true,'disabled'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('sellPrice','money',array('mapped'=>false,'grouping'=>true,'disabled'=>true,'attr'=>array('class'=>'input-mini')))
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
