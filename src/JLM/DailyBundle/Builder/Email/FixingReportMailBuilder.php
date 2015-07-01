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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FixingReportMailBuilder extends FixingMailBuilder
{

	public function buildSubject()
	{
		$this->setSubject('Compte-rendu de l\'intervention');
	}
	
	public function buildBody()
	{
		$this->setBody('Bonjour,'.chr(10).chr(10)
		.'Le technicien à terminé son intervention'.chr(10)
		.'Vous recevrez le compte-rendu'.chr(10)
		.'Cordialement'
		.$this->_getSignature()
		);
	}
	
	public function buildAttachements()
	{
		
	}
}