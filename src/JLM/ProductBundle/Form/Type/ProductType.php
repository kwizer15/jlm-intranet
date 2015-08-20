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
use JLM\ProductBundle\EventListener\ProductTypeSubscriber;
use JLM\CoreBundle\EventListener\FormEntitySubscriber;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductType extends AbstractType
{
	/**
	 * @var ObjectManager
	 */
	private $om;
	
	/**
	 * Constructor
	 * @param ObjectManager $om
	 */
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
       		->add('reference',null,array('attr'=>array('class'=>'input-small')))
//          ->add('barcode',null,array('label'=>'Code barre','required'=>false,'attr'=>array('class'=>'input-xlarge')))
            ->add('category')
            ->add('designation',null,array('attr'=>array('class'=>'input-xxlarge')))
            ->add('description',null,array('required'=>false,'attr'=>array('class'=>'input-xxlarge')))
//            ->add('supplier',null,array('label'=>'Fournisseur')) // Typeahead
            ->add('unity',null,array('attr'=>array('class'=>'input-small')))
//			->add('purchase','money',array('label'=>'Prix d\'achat HT','grouping'=>true,'attr'=>array('class'=>'input-small')))
//            ->add('discountSupplier','percent',array('type'=>'integer','label'=>'Remise fournisseur','attr'=>array('class'=>'input-mini')))
//            ->add('expenseRatio','percent',array('type'=>'integer','label'=>'Frais','attr'=>array('class'=>'input-mini')))
//            ->add('shipping','money',array('label'=>'Port','grouping'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('unitPrice','money',array('grouping'=>true,'attr'=>array('class'=>'input-mini')))
            ->add('supplierPurchasePrices', 'collection', array(
            		'type' => 'jlm_product_supplierpurchaseprice',
            		'prototype' => true,
            		'allow_add' => true,
            		'allow_delete' => true,
            		
            ))
            ->add('sumbit','submit')
            ->addEventSubscriber(new FormEntitySubscriber($this->om))
            ->addEventSubscriber(new ProductTypeSubscriber())
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
