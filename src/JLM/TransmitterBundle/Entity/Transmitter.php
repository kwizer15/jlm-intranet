<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JLM\TransmitterBundle\Model\TransmitterInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Transmitter implements TransmitterInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $number = null;

    /**
     * @var string
 	 * @Assert\Regex(pattern="/^(0[1-9]|1[0-2])[0-9][0-9]$/", message="Garantie au mauvais format")
     */
    private $guarantee = null;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var boolean
     */
    private $isActive = true;

    /**
     * @var Attribution
     */
    private $attribution;
    
    /**
     * @var UserGroup
     */
    private $userGroup;
    
    /**
     * @var Model
     */
    private $model;
    
    /**
     * $this remplace $replacedTransmitter 
     * @var Transmitter replacedTransmitter
     */
    private $replacedTransmitter;
    
    /**
     * $replace replace $this
     * @var Transmitter replace
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
    public function setAttribution(Attribution $attribution = null)
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
    public function setUserGroup(UserGroup $userGroup = null)
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
    public function setModel(Model $model = null)
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
    public function setReplacedTransmitter(Transmitter $replacedTransmitter = null)
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
    public function setReplace(Transmitter $replace = null)
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