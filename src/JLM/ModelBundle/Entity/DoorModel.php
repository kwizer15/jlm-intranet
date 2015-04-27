<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * JLM\ModelBundle\Entity\DoorModel
 *
 * @ORM\Table(name="door_models")
 * @ORM\Entity
 */
class DoorModel
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
     * @var string
     *
     * @ORM\Column(name="name")
     * @Assert\NotNull
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    private $name = '';
    
    /**
     * Type de porte
     * @var DoorType $type
     *
     * @ORM\ManyToOne(targetEntity="DoorType")
     */
    private $type;

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
     * Set text
     *
     * @param string $text
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Get text
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
        return $this->getName();
    }
    
    /**
     * Set type
     *
     * @param JLM\ModelBundle\Entity\DoorType $type
     * @return Door
     */
    public function setType(DoorType $type = null)
    {
    	$this->type = $type;
    
    	return $this;
    }
    
    /**
     * Get type
     *
     * @return JLM\ModelBundle\Entity\DoorType
     */
    public function getType()
    {
    	return $this->type;
    }
}