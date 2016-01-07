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
class WorkEndMailBuilder extends WorkMailBuilder
{

	public function buildSubject()
	{
		$source = $this->_getSource();
		$this->setSubject('Installation '.$this->getWork()->getInstallationCode().' : Travaux'.$source.' terminés');
	}
	
	public function buildBody()
	{
		$this->setBody('Bonjour,'.chr(10).chr(10)
		.'Les travaux'.$source.' ont bien été réalisés le '.$this->getWork()->getLastDate()->format('d/m/Y').'.'.chr(10);
		.'L\'installation est en fonction.'.chr(10).chr(10);
		.$this->_getSignature()
		);
	}
	
	protected function _getSource()
	{
		$source = '';
		$quote = $this->getWork()->getQuote();
		if ($quote = $this->getWork()->getQuote() !== null)
		{
			$source = ' selon devis n°'.$quote->getNumber();
		}
		elseif ($intervention = $this->getWork()->getIntervention() !== null)
		{
			$source = ' selon intervention du '.$intervention->getLastDate()->format('d/m/Y');
		}
		
		return $source;
	}
}