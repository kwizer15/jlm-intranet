<?php
namespace JLM\FeeBundle\Model;

use JLM\Bill\Model\BillFactoryInterface;

interface FeesFollowerInterface
{
	/**
	 * La génération de redevance peut-elle être lancée ?
	 * @return bool
	 */
	public function isActive();
	
	/**
	 * Défini la date d'activation
	 * @param \DateTime $date
	 */
	public function setActivation(\DateTime $date);
}