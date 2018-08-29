<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\ContractBundle\Form\Type\ContractType;
use JLM\ContractBundle\Form\Type\ContractStopType;
use JLM\ProductBundle\Form\Type\StockType;
use JLM\ProductBundle\Form\Type\InventoryType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class StockManager extends Manager
{
           
    /**
     * {@inheritdoc}
     */
    protected function getFormParam($name, $options = [])
    {
        switch ($name) {
            case 'edit':
                return [
                        'method' => 'POST',
                        'route'  => 'jlm_product_stock_update',
                        'params' => ['id' => $options['entity']->getId()],
                        'label'  => 'Modifier',
                        'type'   => new StockType(),
                        'entity' => $options['entity'],
                       ];
            case 'inventory':
                return [
                        'method' => 'POST',
                        'route'  => 'jlm_product_stock_inventory',
                        'params' => [],
                        'label'  => 'Valider',
                        'type'   => new InventoryType(),
                        'entity' => $options['entity'],
                       ];
        }
    
        return parent::getFormParam($name, $options);
    }
}
