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

use JLM\ContactBundle\Model\ContactInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactManager extends BaseManager
{
	protected function getObjectByType($type)
	{
		$objects = array(
			'person' => 'JLM\\ContactBundle\\Entity\\Person',
			'company' => 'JLM\\ContactBundle\\Entity\\Company',
			'association' => 'JLM\\ContactBundle\\Entity\\Association',
		);
		if (array_key_exists($type, $objects))
		{
			return new $objects[$type];
		}
		
		return null;
	}
	
	protected function getFormType($type = null)
	{
		$objects = array(
				'person' => 'JLM\\ContactBundle\\Form\\Type\\PersonType',
				'company' => 'JLM\\ContactBundle\\Form\\Type\\CompanyType',
				'association' => 'JLM\\ContactBundle\\Form\\Type\\AssociationType',
		);
		if (array_key_exists($type, $objects))
		{
			return new $objects[$type];
		}
	
		return null;
	}
	
	public function getEntity($id = null)
	{
		$entity = $this->getObjectByType($id);
		if (null === $entity)
		{
			$entity = $this->getRepository()->find($id);
			if (!$entity)
			{
				throw $this->createNotFoundException('Unable to find Contact entity.');
			}
		}

		return $entity;
	}
	
	protected function getFormParam($method, $options)
	{
		if (!in_array($method, array('POST', 'PUT')))
		{
			return null;
		}
		$entity = (isset($options['entity'])) ? $options['entity'] : null;
		$entityType = (isset($options['type'])) ? $options['type'] : null;
		$entityType = ($entity instanceof ContactInterface) ? $entity->getType() : $entityType ;
		
		switch ($method)
		{
			case 'POST':
				return array(
					'route' => 'jlm_contact_contact_create',
					'params' => array('id' => $entityType),
					'label' => 'Créer',
					'type'  => $this->getFormType($entityType),
				);
			case 'PUT' :
				return array(
					'route' => 'jlm_contact_contact_update',
					'params' => array('id' => $entity->getId()),
					'label' => 'Modifier',
					'type'  => $this->getFormType($entityType),
				);
		}
	}
}