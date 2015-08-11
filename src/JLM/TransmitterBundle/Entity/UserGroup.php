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
use JLM\ModelBundle\Entity\Site;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class UserGroup
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var ArrayCollection
     * @Assert\NotNull
     */
    private $site;

    /**
     * @var Model
     * @Assert\NotNull
     */
    private $model;
    
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
     * Set name
     *
     * @param string $name
     * @return UserGroup
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set site
     *
     * @param Site $site
     * @return UserGroup
     */
    public function setSite(Site $site = null)
    {
        $this->site = $site;
    
        return $this;
    }

    /**
     * Get site
     *
     * @return \JLM\ModelBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
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
     * To String
     * @return string
     */
    public function __toString()
    {
    	return $this->getName();
    }
}