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
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractManager extends Manager
{			
	protected function getFormParam($entity)
	{
		$id = ($entity) ? $entity->getId() : 0;
		return array(
			'POST' => array(
				'route' => 'jlm_contract_contract_create',
				'params' => array(),
				'label' => 'Créer',
				'type'  => new ContractType(),
			),
			'PUT' => array(
				'route' => 'jlm_contract_contract_update',
				'params' => array('id' => $id),
				'label' => 'Modifier',
				'type'  => new ContractType(),
			),
			'DELETE' => array(
				'route' => 'jlm_contract_contract_delete',
				'params' => array('id' => $id),
				'label' => 'Supprimer',
				'type' => 'form',
			),
		);
	}
	
	public function populateForm($form)
	{
		$door = $this->setterFromRequest('door', 'JLMModelBundle:Door');
		if ($door)
		{
			$form->get('door')->setData($door);
			$form->get('trustee')->setData($door->getSite()->getTrustee());
		}
		$begin = $form->get('begin');
		if (!$begin->getData())
		{
			$begin->setData(new \DateTime);
		}
		
		return $form;
	}
	
	public function getEditUrl($id)
	{
		return $this->router->generate('jlm_contract_contract_edit', array('id' => $id));
	}
}