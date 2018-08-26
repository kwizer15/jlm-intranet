<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\ContractBundle\Form\Type\ContractType;
use JLM\ContractBundle\Form\Type\ContractStopType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractManager extends Manager
{
           
    /**
     * {@inheritdoc}
     */
    protected function getFormParam($name, $options = [])
    {
        switch ($name) {
            case 'new':
                return [
                    'method' => 'POST',
                    'route' => 'jlm_contract_contract_create',
                    'params' => [],
                    'label' => 'Créer',
                    'type'  => new ContractType(),
                    'entity' => null,
                ];
            case 'edit':
                return [
                    'method' => 'POST',
                    'route' => 'jlm_contract_contract_update',
                    'params' => ['id' => $options['entity']->getId(), 'formName'=>'edit'],
                    'label' => 'Modifier',
                    'type'  => new ContractType(),
                    'entity' => $options['entity'],
                ];
            case 'delete':
                return [
                    'method' => 'DELETE',
                    'route' => 'jlm_contract_contract_delete',
                    'params' => ['id' => $options['entity']->getId()],
                    'label' => 'Supprimer',
                    'type'  => 'form',
                    'entity' => $options['entity'],
                ];
            case 'stop':
                return [
                        'method' => 'PUT',
                        'route' => 'jlm_contract_contract_update',
                        'params' => ['id' => $options['entity']->getId(), 'formName'=>'stop'],
                        'label' => 'Arrêter',
                        'type'  => new ContractStopType(),
                        'entity' => $options['entity'],
                ];
        }
    
        return parent::getFormParam($name, $options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function populateForm($form)
    {
        if ($form->getName() == 'jlm_contract_contract') {
            $door = $this->setterFromRequest('door', 'JLMModelBundle:Door');
            if ($door) {
                $form->get('door')->setData($door);
                $form->get('trustee')->setData($door->getSite()->getTrustee());
            }
            $begin = $form->get('begin');
            if (!$begin->getData()) {
                $begin->setData(new \DateTime);
            }
        }
        
        return parent::populateForm($form);
    }
    
    public function getEditUrl($id)
    {
        return $this->router->generate('jlm_contract_contract_edit', ['id' => $id]);
    }
}
