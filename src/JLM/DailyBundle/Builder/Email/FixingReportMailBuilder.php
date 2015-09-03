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
		$this->setSubject('Intervention #'.$this->getFixing()->getId().' Compte-rendu');
	}
	
	public function buildBody()
	{
		$this->setBody('Bonjour,'.chr(10).chr(10)
		.'Suite à notre intervention du .'.$this->getFixing()->getLastDate()->format('d/m/Y').' sur l\'installation :'.chr(10)
		.chr(10)
		.$this->getFixing()->getInstallationCode().chr(10)
		.$this->getFixing()->getPlace().chr(10)
		.chr(10)
		.'nous avons constaté '.$this->_getConstat().chr(10)
		.chr(10)
		.'Cordialement'
		.$this->_getSignature()
		);
	}
	
	public function buildAttachements()
	{
		
	}
	
	protected function _getConstat()
	{
		$part = ($this->getFixing()->getPartFamily() === null) ? 'aucun' : strtolower($this->getFixing()->getPartFamily()->getName());
		if ($part == 'aucun')
		{
			return 'après plusieurs essais que l\'intallation était fonctionnelle.';
		}
		$out = 'un';
		$due = $this->getFixing()->getDue();
		if ($due !== null)
		{
			$cause = ($due->getId() != 4) ? 'e '.strtolower($due->getName()) : ' dysfonctionnement';
			$out .= $cause.' sur les élements d';
			$suite = (in_array(substr($part,0,1),array('a','e','i','o','u'))) ? '\'' : 'e ';
			
			return $out.$suite.$part.'.';
		}
		
		return 'après plusieurs essais que l\'intallation était fonctionnelle.';
	}
}