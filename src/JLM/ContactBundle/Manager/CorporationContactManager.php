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

use JLM\ContactBundle\Form\Type\CorporationContactType;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CorporationContactManager extends BaseManager
{		
	public function getEntity($id = null)
	{
		$entity = $this->getRepository()->find($id);
		if (!$entity)
		{
			$class = $this->class;
			
			$entity = new $class();
			if ($corpo = $this->setterFromRequest('corporation_id', 'JLMContactBundle:Corporation'))
			{
				$entity->setCorporation($corpo);
			}
			if ($person = $this->setterFromRequest('person_id', 'JLMContactBundle:Person'))
			{
				$entity->setContact($person);
			}
		}
		
		return $entity;
	}
	
	private function setterFromRequest($param, $repoName)
	{
		$id = $this->request->get($param);
		if ($id)
		{
			$entity = $this->om->getRepository($repoName)->find($id);
	
			return $entity;
		}
	
		return null;
	}
	
	protected function getFormParam($entity)
	{
		$id = $entity->getId();
		return array(
			'POST' => array(
				'route' => 'jlm_contact_corporationcontact_create',
				'params' => array(),
				'label' => 'Créer',
				'type'  => $this->getFormType(),
			),
			'PUT' => array(
				'route' => 'jlm_contact_corporationcontact_update',
				'params' => array('id' => $id),
				'label' => 'Modifier',
				'type'  => $this->getFormType(),
			),
			'DELETE' => array(
				'route' => 'jlm_contact_corporationcontact_delete',
				'params' => array('id' => $id),
				'label' => 'Supprimer',
				'type' => 'form',
			),
		);
	}
	
	public function getEditUrl($id)
	{
		return $this->router->generate('jlm_contact_corporationcontact_edit', array('id' => $id));
	}
	
	public function getFormType($type = null)
	{
		return new CorporationContactType();
	}
}