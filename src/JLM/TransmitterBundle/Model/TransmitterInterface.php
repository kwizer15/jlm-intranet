<?php

namespace JLM\TransmitterBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Transmitter
 *
 * @ORM\Table(name="transmitters_transmitters")
 * @ORM\Entity(repositoryClass="JLM\TransmitterBundle\Entity\TransmitterRepository")
 */
interface TransmitterInterface
{
   
    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber();

    /**
     * Get guarantee
     *
     * @return integer 
     */
    public function getGuarantee();
    
    /**
     * Get guaranteeDate
     *
     * @return DateTime
     */
    public function getGuaranteeDate();
    
    /**
     * Get end guarantee
     *
     * @return string
     */
    public function getEndGuarantee();

    /**
     * Get guaranteeDate
     *
     * @return DateTime
     */
    public function getEndGuaranteeDate();
    
    /**
     * Get suffix
     *
     * @return integer 
     */
    public function getSuffix();

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName();

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive();

    /**
     * Get attribution
     *
     * @return AttributionInterface
     */
    public function getAttribution();

    /**
     * Get userGroup
     *
     * @return \JLM\TransmitterBundle\Entity\UserGroup 
     */
    public function getUserGroup();
    
    /**
     * Get model
     *
     * @return \JLM\TransmitterBundle\Entity\Model
     */
    public function getModel();
    
    /**
     * Vérifie la date de garantie
     * @return bool
     */
    public function isGuaranteeValid();
    
    /**
     * To String
     * 
     * @return string
     */
    public function __toString();


    /**
     * Get replacedTransmitter
     *
     * @return TransmitterInterface
     */
    public function getReplacedTransmitter();

    /**
     * Get replace
     *
     * @return TransmitterInterface
     */
    public function getReplace();
}