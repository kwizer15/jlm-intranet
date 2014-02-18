<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Model\CompanyInterface;
use JLM\ContactBundle\Model\PersonInterface;

/**
 * CompanyDecorator
 *
 * @ORM\MappedSuperclass
 */
abstract class CompanyDecorator extends ContactDecorator implements CompanyInterface
{
    /**
     * @var CompanyInterface
     *
     * @ORM\ManyToOne(targetEntity="JLM\ContactBundle\Model\CompanyInterface")
     */
    private $company;
    
    /**
     * Constructor
     * 
     * @param CompanyInterface $company
     */
    public function __construct(CompanyInterface $company)
    {
    	$this->company = $company;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
    	$this->company->setName($name);
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    	return $this->company->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSiret($siret)
    {
    	$this->company->setSiret($siret);
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSiret()
    {
    	return $this->company->getSiret();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSiren($siren)
    {
    	$this->company->setSiren($siren);

    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSiren()
    {
    	return $this->company->getSiren();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setNic($nic)
    {
    	$this->company->setNic($nic);
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getNic()
    {
    	return $this->company->getNic();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addContact(PersonInterface $contacts)
    {
        $this->company->addContact($contacts);
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeContact(PersonInterface $contacts)
    {
    	$this->company->removeContact($contacts);
    	
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContacts()
    {
        return $this->company->getContacts();
    }
}