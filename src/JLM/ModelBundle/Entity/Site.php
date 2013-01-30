<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Site
 *
 * @ORM\Table(name="sites")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\SiteRepository")
 */
class Site
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
     * @var boolean $accession
     * true = accession
     * false = social
     * null = unknown
     * @ORM\Column(name="accession", type="boolean")
     */
    private $accession;
    
    /**
     * @var Address $address
     * 
     * @ORM\OneToOne(targetEntity="Address")
     */
    private $address;
    
    /**
     * @var string $groupnumber
     * 
     * @ORM\Column(name="groupNumber", type="string", length=6, nullable=true)
     */
    private $groupNumber;
    
    /**
     * @var ArrayCollection $doors
     * 
     * @ORM\OneToMany(targetEntity="Door", mappedBy="site")
     */
    private $doors;
    
    /**
     * @var ArrayCollection $contacts
     *
     * @ORM\OneToMany(targetEntity="SiteContact", mappedBy="site")
     */
    private $contacts;
    
    /**
     * @var Trustee $trustee
     * 
     * @ORM\ManyToOne(targetEntity="Trustee",inversedBy="sites")
     */
    private $trustee;
    
    /**
     * @var VAT $vat
     * 
     * @ORM\ManyToOne(targetEntity="VAT")
     */
    private $vat;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->doors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set accession
     *
     * @param boolean $accession
     * @return Trustee
     */
    public function setAccession($accession)
    {
    	$this->accession = $accession;
    
    	return $this;
    }
    
    /**
     * Get accession
     *
     * @return boolean
     */
    public function getAccession()
    {
    	return $this->accession;
    }
    
    
    /**
     * Set address
     *
     * @param JLM\ModelBundle\Entity\Address $address
     * @return Site
     */
    public function setAddress(\JLM\ModelBundle\Entity\Address $address = null)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return JLM\ModelBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set groupnumber
     * 
     */
    public function setGroupNumber($groupNumber)
    {
    	$this->groupNumber = $groupNumber;
    	return $this;
    }
    
    /**
     * Get groupnumber
     *
     */
    public function getGroupNumber()
    {
    	return $this->groupNumber;
    }
    
    /**
     * Add doors
     *
     * @param JLM\ModelBundle\Entity\Door $doors
     * @return Site
     */
    public function addDoor(\JLM\ModelBundle\Entity\Door $doors)
    {
        $this->doors[] = $doors;
    
        return $this;
    }

    /**
     * Remove doors
     *
     * @param JLM\ModelBundle\Entity\Door $doors
     */
    public function removeDoor(\JLM\ModelBundle\Entity\Door $doors)
    {
        $this->doors->removeElement($doors);
    }

    /**
     * Get doors
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDoors()
    {
        return $this->doors;
    }

    /**
     * Add contacts
     *
     * @param JLM\ModelBundle\Entity\Person $contacts
     * @return Site
     */
    public function addContact(\JLM\ModelBundle\Entity\Person $contacts)
    {
        $this->contacts[] = $contacts;
    
        return $this;
    }

    /**
     * Remove contacts
     *
     * @param JLM\ModelBundle\Entity\Person $contacts
     */
    public function removeContact(\JLM\ModelBundle\Entity\Person $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set trustee
     *
     * @param JLM\ModelBundle\Entity\Trustee $trustee
     * @return Site
     */
    public function setTrustee(\JLM\ModelBundle\Entity\Trustee $trustee = null)
    {
        $this->trustee = $trustee;
    
        return $this;
    }

    /**
     * Get trustee
     *
     * @return JLM\ModelBundle\Entity\Trustee 
     */
    public function getTrustee()
    {
        return $this->trustee;
    }

    /**
     * Set vat
     *
     * @param JLM\ModelBundle\Entity\VAT $vat
     * @return Site
     */
    public function setVat(\JLM\ModelBundle\Entity\VAT $vat = null)
    {
        $this->vat = $vat;
    
        return $this;
    }

    /**
     * Get vat
     *
     * @return JLM\ModelBundle\Entity\VAT 
     */
    public function getVat()
    {
        return $this->vat;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getAddress().'';
    }
}