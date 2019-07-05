<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JLM\TransmitterBundle\Model\TransmitterInterface;

/**
 * Transmitter
 *
 * @ORM\Table(name="transmitters_transmitters")
 * @ORM\Entity(repositoryClass="JLM\TransmitterBundle\Entity\TransmitterRepository")
 */
class Transmitter implements TransmitterInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=6)
     */
    private $number = null;

    /**
     * @var string
     *
     * @ORM\Column(name="guarantee", type="string",length=4)
 	 * @Assert\Regex(pattern="/^(0[1-9]|1[0-2])[0-9][0-9]$/", message="Garantie au mauvais format")
     */
    private $guarantee = null;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=255, nullable=true)
     */
    private $userName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive = true;

    /**
     * @var Attribution
     *
     * @ORM\ManyToOne(targetEntity="Attribution", inversedBy="transmitters")
     */
    private $attribution;
    
    /**
     * @var UserGroup
     *
     * @ORM\ManyToOne(targetEntity="UserGroup")
     */
    private $userGroup;
    
    /**
     * @var Model
     * 
     * @ORM\ManyToOne(targetEntity="Model")
     */
    private $model;
    
    /**
     * $this remplace $replacedTransmitter 
     * @var Tranmitter replacedTransmitter
     *
     * @ORM\OneToOne(targetEntity="Transmitter", inversedBy="replace")
     */
    private $replacedTransmitter;
    
    /**
     * $replace replace $this
     * @var Tranmitter replace
     *
     * @ORM\OneToOne(targetEntity="Transmitter",mappedBy="replacedTransmitter")
     */
    private $replace;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Transmitter
     */
    public function setNumber($number)
    {
    	while (strlen($number) < 6)
    		$number = '0'.$number;
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
    	return $this->number;
    }

    /**
     * Set guarantee
     *
     * @param integer $guarantee
     * @return Transmitter
     */
    public function setGuarantee($guarantee)
    {
    	while (strlen($guarantee) < 4)
    		$guarantee = '0'.$guarantee;
        $this->guarantee = $guarantee;
    
        return $this;
    }

    /**
     * Get guarantee
     *
     * @return integer 
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
     * Get end guarantee
     *
     * @return string
     */
    public function getEndGuarantee()
    {
    	$number = $this->guarantee + 2;
    	while (strlen($number) < 4)
    		$number = '0'.$number;
    	return $number;
    }

    /**
     * Get guaranteeDate
     *
     * @return DateTime
     */
    public function getEndGuaranteeDate()
    {
    	return \DateTime::createFromFormat('my',$this->getEndGuarantee());
    }
    
    /**
     * Set suffix
     *
     * @param integer $suffix
     * @return Transmitter
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    
        return $this;
    }

    /**
     * Get suffix
     *
     * @return integer 
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set userName
     *
     * @param string $userName
     * @return Transmitter
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    
        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Transmitter
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set attribution
     *
     * @param \JLM\TransmitterBundle\Entity\Attribution $attribution
     * @return Transmitter
     */
    public function setAttribution(\JLM\TransmitterBundle\Entity\Attribution $attribution = null)
    {
        $this->attribution = $attribution;
    
        return $this;
    }

    /**
     * Get attribution
     *
     * @return \JLM\TransmitterBundle\Entity\Attribution
     */
    public function getAttribution()
    {
        return $this->attribution;
    }

    /**
     * Set userGroup
     *
     * @param \JLM\TransmitterBundle\Entity\UserGroup $userGroup
     * @return Transmitter
     */
    public function setUserGroup(\JLM\TransmitterBundle\Entity\UserGroup $userGroup = null)
    {
        $this->userGroup = $userGroup;
    
        return $this;
    }

    /**
     * Get userGroup
     *
     * @return \JLM\TransmitterBundle\Entity\UserGroup 
     */
    public function getUserGroup()
    {
        return $this->userGroup;
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
     * Vérifie la date de garantie
     * @return bool
     * @Assert\IsTrue(message="La date de début de garantie doit se situer AVANT ou PENDANT le mois en cours")
     */
    public function isGuaranteeValid()
    {
    	$today = new \DateTime;
    	$gar = $this->getGuaranteeDate();
    	if ($gar <= $today)
    		return true;
    	return false;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getNumber();
    }

    /**
     * Set replacedTransmitter
     *
     * @param \JLM\TransmitterBundle\Entity\Transmitter $replacedTransmitter
     * @return Transmitter
     */
    public function setReplacedTransmitter(\JLM\TransmitterBundle\Entity\Transmitter $replacedTransmitter = null)
    {
        $this->replacedTransmitter = $replacedTransmitter;
        $this->replacedTransmitter->setReplace($this);
        return $this;
    }

    /**
     * Get replacedTransmitter
     *
     * @return \JLM\TransmitterBundle\Entity\Transmitter 
     */
    public function getReplacedTransmitter()
    {
        return $this->replacedTransmitter;
    }

    /**
     * Set replace
     *
     * @param \JLM\TransmitterBundle\Entity\Transmitter $replace
     * @return Transmitter
     */
    public function setReplace(\JLM\TransmitterBundle\Entity\Transmitter $replace = null)
    {
        $this->replace = $replace;
    
        return $this;
    }

    /**
     * Get replace
     *
     * @return \JLM\TransmitterBundle\Entity\Transmitter 
     */
    public function getReplace()
    {
        return $this->replace;
    }
}