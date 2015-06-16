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
class FixingEndMailBuilder extends FixingMailBuilder
{

	public function buildSubject()
	{
		$this->setSubject('Intervention terminée');
	}
	
	public function buildBody()
	{
		$this->setBody('Bonjour,'.chr(10).chr(10)
		.'Le technicien à terminé son intervention'.chr(10)
		.'Vous recevrez le compte-rendu dans les plus-bref délais'.chr(10).chr(10)
		.'Cordialement'
		);
	}
	
	public function buildAttachements()
	{
		
	}
}