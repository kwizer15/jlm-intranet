<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactManager extends Manager
{
   
    protected function getFormType($type = null)
    {
        $objects = [
                'person' => 'JLM\\ContactBundle\\Form\\Type\\PersonType',
                'company' => 'JLM\\ContactBundle\\Form\\Type\\CompanyType',
                'association' => 'JLM\\ContactBundle\\Form\\Type\\AssociationType',
        ];
        if (array_key_exists($type, $objects)) {
            return new $objects[$type];
        }
    
        return null;
    }
    
    protected function getFormParam($name, $options = [])
    {
        switch ($name) {
            case 'new':
                return [
                    'method' => 'POST',
                    'route' => 'jlm_contact_contact_create',
                    'params' => ['id' => $options['type']],
                    'label' => 'Créer',
                    'type'  => $this->getFormType($options['type']),
                    'entity' => null,
                ];
            case 'edit':
                return [
                    'method' => 'POST',
                    'route' => 'jlm_contact_contact_update',
                    'params' => ['id' => $options['entity']->getId()],
                    'label' => 'Modifier',
                    'type'  => $this->getFormType($options['type']),
                    'entity' => $options['entity']
                ];
        }
        
        return parent::getFormParam($name, $options);
    }
}
