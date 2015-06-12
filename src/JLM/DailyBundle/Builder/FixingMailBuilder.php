<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder;

use JLM\DailyBundle\Model\FixingInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FixingMailBuilder extends SwiftMailBuilderAbstract
{
	private $fixing;
	
	public function __construct(FixingInterface $fixing)
	{
		$this->fixing = $fixing;
	}
	
	public function buildSubject()
	{
		$this->setSubject('Demande d\'intervention prise en compte');
	}

	public function buildFrom()
	{
		$this->addBcc('secretariat@jlm-entreprise.fr', 'Secrétariat (JLM Entreprise)');
	}
	
	public function buildTo()
	{
		$managerContacts = $this->fixing->getManagerContacts();
		foreach ($managerContacts as $contact)
		{
			$this->addTo($contact->getEmail(), $contact->getName());
		}
	}
	
	public function buildCc()
	{
		$administratorContacts = $this->fixing->getAdministratorContacts();
		foreach ($administratorContacts as $contact)
		{
			$this->addCc($contact->getEmail(), $contact->getName());
		}
	}
	
	public function buildBcc()
	{
		$this->addBcc('secretariat@jlm-entreprise.fr', 'Secrétariat (JLM Entreprise)');
	}
	
	public function buildBody()
	{
		
	}
	
	public function buildAttachements()
	{
		
	}
}