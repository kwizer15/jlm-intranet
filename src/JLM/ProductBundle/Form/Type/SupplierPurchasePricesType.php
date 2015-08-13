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
class SupplierPurchasePricesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_product_supplierpurchaseprices';
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
    	return 'collection';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
        ->setDefaults(array(
            'type' => 'jlm_product_supplierpurchaseprice',
        ));
    }
}
