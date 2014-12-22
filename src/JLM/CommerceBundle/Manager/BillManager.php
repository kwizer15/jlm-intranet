<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\CommerceBundle\Form\Type\BillType;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillManager extends Manager
{	
	protected function getFormParam($name, $options = array())
	{
		switch ($name)
		{
			case 'new' :
				return array(
					'method' => 'POST',
					'route' => 'bill_create',
					'params' => array(),
					'label' => 'Créer',
					'type'  => new BillType(),
					'entity' => null,
				);
			case 'edit' :
				return array(
					'method' => 'PUT',
					'route' => 'bill_update',
					'params' => array('id' => $options['entity']->getId()),
					'label' => 'Modifier',
					'type'  => new BillType(),
					'entity' => $options['entity']
				);
		}
		
		return parent::getFormParam($name, $options);
	}
}