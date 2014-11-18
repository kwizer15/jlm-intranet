<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface ProductInterface
{
    /**
     * Get unitPrice
     *
     * @return float
     */
    public function getUnitPrice($quantity = null);
    
    /**
     * Get reference
     *
     * @return string
     */
    public function getReference();
    
    /**
     * Get category
     *
     * @return ProductCategoryInterface
     */
    public function getCategory();
    
    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation();
    
    /**
     * Get description
     *
     * @return text
     */
    public function getDescription();
    
    /**
     * Get is small supplies
     * @return boolean
     */
    public function isSmallSupply();
    
    /**
     * Get if is service
     * @return boolean
    */
    public function isService();
}