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

use JLM\CoreBundle\Form\Type\AbstractSelectType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductSelectType extends AbstractSelectType
{

    protected function getTransformerClass()
    {
        return '\JLM\ProductBundle\Form\DataTransformer\ProductToIntTransformer';
    }
    
    protected function getTypeName()
    {
        return 'jlm_product_product';
    }
}
