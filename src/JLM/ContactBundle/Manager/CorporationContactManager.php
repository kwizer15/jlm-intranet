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
use Assetic\Exception\Exception;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CorporationContactManager extends BaseManager
{		
	public function getEntity($id = null)
	{
		return $this->getRepository()->find($id);
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
	
	protected function getFormParam($method, $options = array())
	{
		if (!in_array($method, array('POST', 'PUT', 'DELETE')))
		{
			return null;
		}
		$entity = (isset($options['entity'])) ? $options['entity'] : null; 
		switch ($method)
		{
			case 'POST':
				return array(
					'route' => 'jlm_contact_corporationcontact_create',
					'params' => array(),
					'label' => 'Créer',
					'type'  => new CorporationContactType(),
			);
			case 'PUT' :
				return array(
					'route' => 'jlm_contact_corporationcontact_update',
					'params' => array('id' => $entity->getId()),
					'label' => 'Modifier',
					'type'  => new CorporationContactType(),
			);
			case 'DELETE' :
				return array(
					'route' => 'jlm_contact_corporationcontact_delete',
					'params' => array('id' => $entity->getId()),
					'label' => 'Supprimer',
					'type' => 'form',
			);
		}
	}
	
	public function setFormDatas($form)
	{
		if ($corpo = $this->setterFromRequest('corporation_id', 'JLMContactBundle:Corporation'))
		{
			$form->get('corporation')->setData($corpo);
		}
		if ($person = $this->setterFromRequest('person_id', 'JLMContactBundle:Person'))
		{
			$form->get('person')->setData($person);
		}
		
		return $form;
	}
	
	public function getEditUrl($id)
	{
		return $this->router->generate('jlm_contact_corporationcontact_edit', array('id' => $id));
	}
	
	public function getDeleteUrl($id)
	{
		return $this->router->generate('jlm_contact_corporationcontact_confirmdelete', array('id' => $id));
	}
}