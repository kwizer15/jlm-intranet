<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Déplacement
 * JLM\DailyBundle\Entity\Shifting
 *
 * @ORM\Table(name="shifting")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="actionType", type="string")
 * @ORM\DiscriminatorMap({
 * 		"equipment" = "Equipment",
 *  	"fixing" = "Fixing",
 * 		"work" = "Work",
 * 		"maintenance" = "Maintenance",
 * 		"receiver" = "Receiver"
 * })
 */
abstract class Shifting
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime $creation
     *
     * @ORM\Column(name="creation", type="datetime")
     */
    private $creation;
    
    /**
     * Lieu du déplacement
     * @var string
     * @ORM\Column(name="place", type="text")
     */
    private $place;
    
    /**
     * @var string $reason
     *
     * @ORM\Column(name="reason", type="text")
     */
    private $reason;
    

    
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
     * Set creation
     *
     * @param \DateTime $creation
     * @return InterventionPlanned
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;
    
        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime 
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return InterventionPlanned
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Shifting
     */
    public function setPlace($place)
    {
        $this->place = $place;
    
        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }
}