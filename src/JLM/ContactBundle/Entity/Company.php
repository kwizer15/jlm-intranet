<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Model\CompanyPersonInterface;
use JLM\ContactBundle\Model\CompanyInterface;

class CompanyException extends \Exception {}

/**
 * Company
 *
 * @ORM\Table(name="jlm_contact_company")
 * @ORM\Entity
 */
class Company extends Contact implements CompanyInterface
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
	 * @ORM\ManyToMany(targetEntity="JLM\ContactBundle\Model\CompanyPersonInterface", mappedBy="company")
	 */
    private $contacts;
    
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * {@inheritdoc}
     */
    public function setName($name)
    {
    	$this->name = $name;
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    	return $this->name;
    }
    
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getSiret()
    {
    	return $this->getSiren().$this->getNic();
    }
    
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getSiren()
    {
    	return $this->siren;
    }
    
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getNic()
    {
    	return $this->nic;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addContact(CompanyPersonInterface $contacts)
    {
        $this->contacts[] = $contacts;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeContact(CompanyPersonInterface $contacts)
    {
        $this->contacts->removeElement($contacts);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}