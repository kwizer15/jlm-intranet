<?php

namespace JLM\ProductBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\ContractBundle\Form\Type\ContractType;
use JLM\ContractBundle\Form\Type\ContractStopType;
use JLM\ProductBundle\Form\Type\StockType;
use JLM\ProductBundle\Form\Type\InventoryType;

class StockManager extends Manager
{
    /**
     * {@inheritdoc}
     */
    protected function getFormParam(string $name, array $options = []): array
    {
        switch ($name) {
            case 'edit':
                return [
                        'method' => 'POST',
                        'route'  => 'jlm_product_stock_update',
                        'params' => ['id' => $options['entity']->getId()],
                        'label'  => 'Modifier',
                        'type'   => StockType::class,
                        'entity' => $options['entity'],
                       ];
            case 'inventory':
                return [
                        'method' => 'POST',
                        'route'  => 'jlm_product_stock_inventory',
                        'params' => [],
                        'label'  => 'Valider',
                        'type'   => InventoryType::class,
                        'entity' => $options['entity'],
                       ];
        }
    
        return parent::getFormParam($name, $options);
    }
}
