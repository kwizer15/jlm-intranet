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
		$str = chr(10).chr(10);
//				.'Vous pouvez consulter l\'état de vos installations en contrat en vous connectant à votre espace client : http://jlm-entreprise.fr/login'
//				.chr(10).chr(10);
		$date = new \DateTime;
		if ($date->format('m') == '01') {
			$str .= 'Toute l\'équipe de JLM Entreprise vous souhaite une bonne année '.$date->format('Y').'.'.chr(10);
		}
		$str .= 'Cordialement'
				.parent::_getSignature();
		return $str;
	}
}
