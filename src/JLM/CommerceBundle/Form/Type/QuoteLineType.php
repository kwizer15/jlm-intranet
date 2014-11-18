<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteLineType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('position','hidden')
        	->add('product','jlm_product_product_hidden',array('required'=>false))
        	->add('reference',null,array('required'=>false,'attr'=>array('class'=>'input-mini')))
        	->add('designation',null,array('attr'=>array('class'=>'input-xlarge')))
        	->add('description',null,array('required'=>false,'attr'=>array('class'=>'input-xlarge')))
        	->add('showDescription','hidden')
        	->add('quantity',null,array('attr'=>array('class'=>'input-mini')))
        	->add('purchasePrice','money',array('grouping'=>true,'attr'=>array('class'=>'input-mini')))
        	->add('discountSupplier','percent',array('precision'=>0,'attr'=>array('class'=>'input-mini')))
        	->add('expenseRatio','percent',array('precision'=>0,'attr'=>array('class'=>'input-mini')))
        	->add('shipping','money',array('grouping'=>true,'attr'=>array('class'=>'input-mini')))
        	->add('unitPrice','money',array('grouping'=>true,'attr'=>array('class'=>'input-mini')))
        	->add('discount','percent',array('precision'=>0,'attr'=>array('class'=>'input-mini')))
        	->add('vat','percent',array('precision'=>1,'attr'=>array('class'=>'input-mini')))
        	->add('isTransmitter','hidden')

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    			'data_class' => 'JLM\CommerceBundle\Entity\QuoteLine'
    	));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'quote_line';
    }
}