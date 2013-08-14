<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Serie d'émetteurs
 * @author Emmanuel Bernaszuk <kwizer15@wanadoo.fr>
 */
class Series
{
	/**
	 * Nombre d'émetteur de le serie
	 * @var int
	 * @Assert\Min(limit=1,message="La quantité doit être d'au moins 1 émetteur")
	 */
	private $quantity;
	
	/**
	 * Numéro du premier émetteur
	 * @var int
	 * @Assert\Range(
	 * 		min=0,
	 * 		max=999999,
	 *		minMessage="Le numéro du premier émetteur doit être au moins 0",
	 * 		maxMessage="Le numéro du premier émetteur doit être au plus 999999"
	 * )
	 */
	private $first;
	
	/**
	 * Garantie
	 * @var int
 	 * @Assert\Regex(pattern="/^(0[1-9]|1[0-2])[0-9][0-9]$/", message="Le début de garantie doit être au format MMYY")
 	 * @Assert\NotBlank
	 */
	private $guarantee;
	
	/**
	 * Groupe utilisateur
	 * @var UserGroup
	 */
	private $userGroup;
	
	/**
	 * Attribution
	 * @var Attribution
	 */
	private $attribution;
	
	/**
	 * @var Model
	 *
	 * @ORM\ManyToOne(targetEntity="Model")
	 */
	private $model;
	
	/**
	 * Set quantity
	 * @param int $quantity
	 * @return Series
	 */
	public function setQuantity($quantity)
	{
		if ($quantity > 0)
			$this->quantity = $quantity;
		return $this;
	}
	
	/**
	 * Get quantity
	 * @return int
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}
	
	/**
	 * Set first
	 * @param int $first
	 * @return Series
	 */
	public function setFirst($first)
	{
		if ($first >= 0)
			$this->first = (int)$first;
		return $this;
	}
	
	/**
	 * Get first
	 * @return int
	 */
	public function getFirst()
	{
		return $this->first;
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
	 * Set last number
	 * @param int $last
	 * @return Series
	 */
	public function setLast($last)
	{
		$first = $this->getFirst();
		if ($last >= $first)
			$this->quantity = $last - $first + 1;
		return $this;
	}
		
	/**
	 * Get last number
	 * @return int
	 */
	public function getLast()
	{
		if ($this->getFirst() === null)
			return null;
		return ($this->getFirst() + $this->getQuantity() - 1);
	}

	/**
	 * Set UserGroup
	 * @param UserGroup $userGroup
	 * @return Series
	 */
	public function setUserGroup(UserGroup $userGroup)
	{
		$this->userGroup = $userGroup;
		return $this;
	}
	
	/**
	 * Get UserGroup
	 * @return UserGroup
	 */
	public function getUserGroup()
	{
		return $this->userGroup;
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
	 * Set model
	 *
	 * @param \JLM\TransmitterBundle\Entity\Model $model
	 * @return Transmitter
	 */
	public function setModel(\JLM\TransmitterBundle\Entity\Model $model = null)
	{
		$this->model = $model;
	
		return $this;
	}
	
	/**
	 * Get model
	 *
	 * @return \JLM\TransmitterBundle\Entity\Model
	 */
	public function getModel()
	{
		return $this->model;
	}
	
	/**
	 * Get Transmitters
	 * @return array
	 */
	public function getTransmitters()
	{
		$transmitters = array();
		for ($i = $this->getFirst(); $i <= $this->getLast(); $i++)
		{
			$transmitter = new Transmitter;
			$transmitter->setNumber($i);
			$transmitter->setUserGroup($this->getUserGroup());
			$transmitter->setModel($this->getModel());
			$transmitter->setGuarantee($this->getGuarantee());
			$transmitter->setAttribution($this->getAttribution());
			$transmitters[] = $transmitter; 
		}
		return $transmitters;
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