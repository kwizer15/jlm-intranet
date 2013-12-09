<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Model\PersonInterface;

class CompanyException extends \Exception {}

/**
 * Company
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Company extends Contact
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
     * @ORM\Column(name="name", type="integer")
     */
    private $name;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="siren", type="integer")
     */
    private $siren;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="nic", type="integer")
     */
    private $nic;

	/**
	 * @var ArrayCollection
	 * 
	 * @ORM\ManyToMany(targetEntity="Person")
	 */
    private $contacts;
    
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
     * @param string
     * @return self
     */
    public function setName($name)
    {
    	$this->name = $name;
    	return $this;
    }
    
    /**
     * Get name
     * @return string
     */
    public function getName()
    {
    	return $this->name;
    }
    
    /**
     * Set siret
     * @param string
     * @return self
     */
    public function setSiret($siret)
    {
    	$siret = str_replace(array(' ','-','.','/'),'',$siret);
    	if (!preg_match('#^(([0-9]{9})([0-9]{5}))?$#',$siret,$matches))
    		throw new CompanyException('invalid siret');
    	if (isset($matches[2]))
    		$this->setSiren($matches[2]);
    	if (isset($matches[3]))
    		$this->setNic($matches[3]);
    	return $this;
    }
    
    /**
     * Get siret
     * @return string
     */
    public function getSiret()
    {
    	return $this->getSiren().$this->getNic();
    }
    
    /**
     * Set siren
     * @param string $siren
     * @throws CompanyException
     * @return self
     */
    public function setSiren($siren)
    {
    	$siren = str_replace(array(' ','-','.','/'),'',$siren);
    	if (!preg_match('#^([0-9]{9})?$#',$siren,$matches))
    		throw new CompanyException('invalid siren');
    	$this->siren = isset($matches[1]) ? $matches[1] : '';
    	return $this;
    }
    
    /**
     * Get siret
     * @return string
     */
    public function getSiren()
    {
    	return $this->siren;
    }
    
    /**
     * Set nic
     * @param string $nic
     * @throws CompanyException
     * @return self
     */
    public function setNic($nic)
    {
    	$nic = str_replace(array(' ','-','.','/'),'',$nic);
    	if (!preg_match('#^([0-9]{5})?$#',$nic,$matches))
    		throw new CompanyException('invalid nic');
    	$this->nic = isset($matches[1]) ? $matches[1] : '';
    	return $this;
    }
    
    /**
     * Get nic
     * @return string
     */
    public function getNic()
    {
    	return $this->nic;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add contacts
     *
     * @param PersonInterface $contacts
     * @return self
     */
    public function addContact(PersonInterface $contacts)
    {
        $this->contacts[] = $contacts;
    
        return $this;
    }

    /**
     * Remove contacts
     *
     * @param PersonInterface $contacts
     * @return self
     */
    public function removeContact(PersonInterface $contacts)
    {
        $this->contacts->removeElement($contacts);
        return $this;
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}