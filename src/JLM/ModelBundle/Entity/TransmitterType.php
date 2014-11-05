<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\TransmitterType
 *
 * @ORM\Table(name="transmitter_types")
 * @ORM\Entity
 */
class TransmitterType
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
}