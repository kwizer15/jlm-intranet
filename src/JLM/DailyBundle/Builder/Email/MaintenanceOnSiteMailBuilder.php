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
class MaintenanceOnSiteMailBuilder extends MaintenanceMailBuilder
{

	public function buildSubject()
	{
		$this->setSubject('Visite d\'entretien en cours');
	}
	
	public function buildBody()
	{
		$this->setBody('Bonjour,'.chr(10).chr(10)
		.'Technicien sur site pour la visite d\'entretien'.chr(10)
		.'Cordialement'
		);
	}
}