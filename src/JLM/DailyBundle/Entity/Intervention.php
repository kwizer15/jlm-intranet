<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification d'intervention
 * JLM\DailyBundle\Entity\InterventionPlanned
 *
 * @ORM\Table(name="interventions")
 * @ORM\Entity
 */
class Intervention extends Shifting
{
    /**
     * Porte (lien)
     * @var JLM\ModelBundle\Entity\Door
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
     */
    private $door;
    
    /**
     * @var string $contactName
     * @ORM\Column(name="contact_name", type="string", nullable=true)
     */
    private $contactName;
    
    /**
     * @var string $contactPhone
     * @ORM\Column(name="contact_phones", type="text", nullable=true)
     */
    private $contactPhones;
    
    /**
     * E-mail pour envoyer le rapport
     * @var string $contactEmail
     * @ORM\Column(name="contact_email", type="text", nullable=true)
     */
    private $contactEmail;
   
    /**
     * Set contactName
     *
     * @param string $contactName
     * @return InterventionPlanned
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    
        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactPhones
     *
     * @param string $contactPhones
     * @return InterventionPlanned
     */
    public function setContactPhones($contactPhones)
    {
        $this->contactPhones = $contactPhones;
    
        return $this;
    }

    /**
     * Get contactPhones
     *
     * @return string 
     */
    public function getContactPhones()
    {
        return $this->contactPhones;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     * @return InterventionPlanned
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    
        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string 
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    
    /**
     * Set door
     *
     * @param JLM\DailyBundle\Entity\Door $door
     * @return InterventionPlanned
     */
    public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
    {
        $this->door = $door;
    
        return $this;
    }

    /**
     * Get door
     *
     * @return JLM\DailyBundle\Entity\Door 
     */
    public function getDoor()
    {
        return $this->door;
    }

    
    
}