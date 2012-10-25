<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\SiteContact
 *
 * @ORM\Table(name="site_contacts")
 * @ORM\Entity
 */
class SiteContact extends Person
{
	/**
	 * @var ArrayCollection $sites
	 * 
	 * @ORM\ManyToMany(targetEntity="Site", inversedBy="contacts")
	 */
	private $sites;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sites = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add sites
     *
     * @param JLM\ModelBundle\Entity\Site $sites
     * @return SiteContact
     */
    public function addSite(\JLM\ModelBundle\Entity\Site $sites)
    {
        $this->sites[] = $sites;
    
        return $this;
    }

    /**
     * Remove sites
     *
     * @param JLM\ModelBundle\Entity\Site $sites
     */
    public function removeSite(\JLM\ModelBundle\Entity\Site $sites)
    {
        $this->sites->removeElement($sites);
    }

    /**
     * Get sites
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSites()
    {
        return $this->sites;
    }
}