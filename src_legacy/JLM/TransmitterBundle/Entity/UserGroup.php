<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserGroup
 *
 * @ORM\Table(name="transmitters_usergroups")
 * @ORM\Entity(repositoryClass="JLM\TransmitterBundle\Entity\UserGroupRepository")
 */
class UserGroup
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Site", inversedBy="userGroups")
     * @Assert\NotNull
     */
    private $site;

    /**
     * @var Model
     *
     * @ORM\ManyToOne(targetEntity="Model")
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
     * @param \JLM\ModelBundle\Entity\Site $site
     * @return UserGroup
     */
    public function setSite(\JLM\ModelBundle\Entity\Site $site = null)
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
     * To String
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
