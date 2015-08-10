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
		$this->setSubject('Intervention #'.$this->getFixing()->getId().' Intervention terminée');
	}
	
	public function buildBody()
	{
		$this->setBody('Bonjour,'.chr(10).chr(10)
		.'Nous vous informons que le technicien a terminé son intervention.'.chr(10)
		.'L\'installation : '.chr(10)
		.$this->getFixing()->getInstallationCode().chr(10)
		.$this->getFixing()->getPlace().chr(10)
		.chr(10)
		.'est '.$this->_getStringState().$this->_getStringTodo().chr(10)
		.chr(10)
		.'Cordialement'
		.$this->_getSignature()
		);
	}
	
	public function buildAttachements()
	{
		
	}
	
	protected function _getStringState()
	{
		return ($this->getFixing()->getDoor()->isStopped()) ? 'à l\'arrêt' : 'en service';
	}

	protected function _getStringTodo()
	{
		$hasWork = $this->getFixing()->hasWork();
		$hasAskQuote = $this->getFixing()->hasAskQuote();
		$out = ($hasWork || $hasAskQuote) ? ' et nécessite ' : '';
		if ($hasWork)
		{
			$out .= 'une intervention ultérieure';
		}
		if ($hasAskQuote)
		{
			if ($hasWork)
			{
				$out .= ' et ';
			}
			$out .= 'un devis qui vous sera envoyé dans les plus brefs délais';
		}
		$out .= '.';
		
		return $out;
	}
}