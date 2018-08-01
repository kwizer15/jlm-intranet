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
class FixingOnSiteMailBuilder extends FixingMailBuilder
{

	public function buildSubject()
	{
		$this->setSubject('Intervention #'.$this->getFixing()->getId().' - Technicien sur place');
	}
	
	public function buildBody()
	{
		$this->setBody(
			'Bonjour,'.chr(10)
			.chr(10)
			.'Nous vous informons que notre technicien est actuellement sur place et qu\'il procède au dépannage de l\'installation'.chr(10)
			.chr(10)
			.$this->getFixing()->getInstallationCode().chr(10)
			.$this->getFixing()->getPlace().chr(10)
			.chr(10)
			.'Cordialement'
			.$this->_getSignature()
		);
	}
	
	public function buildAttachements()
	{
		
	}
}