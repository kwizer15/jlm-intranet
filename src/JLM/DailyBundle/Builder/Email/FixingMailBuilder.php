<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder\Email;

use JLM\DailyBundle\Model\FixingInterface;
use JLM\CoreBundle\Builder\MailBuilderAbstract;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class FixingMailBuilder extends MailBuilderAbstract
{
	private $fixing;
	
	public function __construct(FixingInterface $fixing)
	{
		$this->fixing = $fixing;
	}

	public function getFixing()
	{
		return $this->fixing;
	}
	
	public function buildFrom()
	{
		$this->addFrom('secretariat@jlm-entreprise.fr', 'Secretariat (JLM Entreprise)');
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
		$this->addBcc('secretariat@jlm-entreprise.fr', 'Secretariat (JLM Entreprise)');
	}
	

	public function buildAttachements()
	{
	
	}
}