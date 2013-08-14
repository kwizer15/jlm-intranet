<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Remplacement d'émetteurs
 * @author Emmanuel Bernaszuk <kwizer15@wanadoo.fr>
 */
class Replacement
{
	/**
	 * Emetteur à remplacer
	 * @var Transmitter
	 */
	private $old;
	
	/**
	 * Numéro du nouvel émetteur
	 * @var string
	 * @Assert\Range(
	 * 		min=0,
	 * 		max=999999,
	 *		minMessage="Le numéro du nouvel émetteur doit être au moins 0",
	 * 		maxMessage="Le numéro du nouvel émetteur doit être au plus 999999"
	 * )
	 */
	private $newNumber;
	
	/**
	 * @var string
	 *
	 * @Assert\Regex(pattern="/^(0[1-9]|1[0-2])[0-9][0-9]$/", message="Garantie au mauvais format")
	 */
	private $guarantee = null;
	
	/**
	 * Attribution
	 * @var Attribution
	 */
	private $attribution;
	
	/**
	 * Set Old
	 * @param Transmitter $old
	 * @return Replacement
	 */
	public function setOld(Transmitter $old)
	{
		$old->setIsActive(false);
		$this->old = $old;
		$this->old->setReplacedTransmitter($this->getNew());
		
		return $this;
	}
	
	/**
	 * Get old
	 * @return Transmitter
	 */
	public function getOld()
	{
		return $this->old;
	}
	
	/**
	 * Set newNumber
	 * @param int $newNumber
	 * @return Replacement
	 */
	public function setNewNumber($newNumber)
	{
		if ($newNumber >= 0)
			$this->newNumber = $newNumber;
		return $this;
	}
	
	/**
	 * Get newNumber
	 * @return string
	 */
	public function getNewNumber()
	{
		return $this->newNumber;
	}
	
	/**
	 * Set guarantee
	 * @param int $guarantee
	 * @return Series
	 */
	public function setGuarantee($guarantee)
	{
		$this->guarantee = $guarantee;
		return $this;
	}
	
	/**
	 * Get guarantee
	 * @return int
	 */
	public function getGuarantee()
	{
		return $this->guarantee;
	}
	
	/**
	 * Get guaranteeDate
	 *
	 * @return DateTime
	 */
	public function getGuaranteeDate()
	{
		return \DateTime::createFromFormat('my',$this->getGuarantee());
	}

	/**
	 * Set Attribution
	 * @param Attribution $attribution
	 * @return Series
	 */
	public function setAttribution(Attribution $attribution)
	{
		$this->attribution = $attribution;
		return $this;
	}
	
	/**
	 * Get Attribution
	 * @return Attribution
	 */
	public function getAttribution()
	{
		return $this->attribution;
	}
	
	/**
	 * Get Transmitters
	 * @return array
	 */
	public function getNew()
	{
		if ($this->getOld() === null)
			return null;
		$transmitter = new Transmitter;
		$transmitter->setModel($this->getOld()->getModel());
		$transmitter->setUserGroup($this->getOld()->getUserGroup());
		$transmitter->setNumber($this->getNewNumber());
		$transmitter->setGuarantee($this->getGuarantee());
		$transmitter->setAttribution($this->getAttribution());
		return $transmitter;
	}
	
	/**
	 * Vérifie la date de garantie
	 * @return bool
	 * @Assert\True(message="La date de début de garantie doit se situer AVANT ou PENDANT le mois en cours")
	 */
	public function isGuaranteeValid()
	{
		$today = new \DateTime;
    	$gar = $this->getGuaranteeDate();
    	if ($gar <= $today)
    		return true;
    	return false;
	}
}