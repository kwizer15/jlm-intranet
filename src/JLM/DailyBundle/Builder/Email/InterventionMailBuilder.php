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

use JLM\CoreBundle\Builder\MailBuilderAbstract;
use JLM\DailyBundle\Model\InterventionInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class InterventionMailBuilder extends MailBuilderAbstract
{
	private $intervention;
	
	public function __construct(InterventionInterface $intervention)
	{
		$this->intervention = $intervention;
	}

	public function getIntervention()
	{
		return $this->intervention;
	}
	
	public function buildFrom()
	{
		$this->addFrom('secretariat@jlm-entreprise.fr', 'Secretariat (JLM Entreprise)');
	}
	
	public function buildTo()
	{
		$managerContacts = $this->intervention->getManagerContacts();
		foreach ($managerContacts as $contact)
		{
			//$this->addTo($contact);
			$this->addTo($contact->getEmail(), $contact->getName());
		}
	}
	
	public function buildCc()
	{
		$administratorContacts = $this->intervention->getAdministratorContacts();
		foreach ($administratorContacts as $contact)
		{
			//$this->addCc($contact);
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
	
	protected function _getSignature()
	{
		return chr(10).chr(10)
		.'--'.chr(10)
		.'JLM Entreprise'.chr(10)
		.'17 avenue de Montboulon'.chr(10)
		.'77165 SAINT-SOUPPLETS'.chr(10)
		.'Tel : 01 64 33 77 70'.chr(10)
		.'Fax : 01 64 33 78 45'
	}
}