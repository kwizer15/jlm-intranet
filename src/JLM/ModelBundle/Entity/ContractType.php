<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\ContractType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ContractType
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
     * @var boolean $complete
     *
     * @ORM\Column(name="complete", type="boolean")
     */
    private $complete;

    /**
     * @var smallint $options
     *
     * @ORM\Column(name="options", type="smallint")
     */
    private $options;


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
     * Set complete
     *
     * @param boolean $complete
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
    }

    /**
     * Get complete
     *
     * @return boolean 
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set options
     *
     * @param smallint $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * Get options
     *
     * @return smallint 
     */
    public function getOptions()
    {
        return $this->options;
    }
}