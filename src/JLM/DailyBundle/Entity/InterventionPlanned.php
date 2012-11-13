<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\DailyBundle\Entity\InterventionPlanned
 *
 * @ORM\Table(name="intervention_planned")
 * @ORM\Entity
 */
class InterventionPlanned
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
     * Porte
     * @var JLM\ModelBundle\Entity\Door
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
     */
    private $door;
    
    /**
     * @var string $contactName
     * @ORM\Column(name="contact_name", type="string")
     */
    private $contactName;
    
    /**
     * @var string $contactPhone
     * @ORM\Column(name="contact_phones", type="text")
     */
    private $contactPhones;
    
    /**
     * E-mail pour envoyer le rapport
     * @var string $contactEmail
     * @ORM\Column(name="contact_email", type="text")
     */
    private $contactEmail;
    
    /**
     * @var string $reason
     *
     * @ORM\Column(name="reason", type="text")
     */
    private $reason;
    
    /**
     * @var ActionType $actionType
     *
     * @ORM\ManyToOne(targetEntity="ActionType")
     */
    private $actionType;
    
    /**
     * Priorité
     * @var int $priority
     * 1 - Très Urgent
     * 2 - Urgent
     * ....
     *
     * @ORM\Column(name="priority", type="smallint")
     */
    private $priority;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
