<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Model\CompanyInterface;
use JLM\ContactBundle\Model\CompanyPersonInterface;

/**
 * CompanyDecorator
 *
 * @ORM\MappedSuperclass
 */
abstract class CompanyDecorator extends ContactDecorator implements CompanyInterface
{
    /**
     * Constructor
     * 
     * @param CompanyInterface $company
     */
    public function __construct(CompanyInterface $company)
    {
    	parent::__construct($company);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
    	$this->getContact()->setName($name);
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    	return $this->getContact()->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSiret($siret)
    {
    	$this->getContact()->setSiret($siret);
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSiret()
    {
    	return $this->getContact()->getSiret();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSiren($siren)
    {
    	$this->getContact()->setSiren($siren);

    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSiren()
    {
    	return $this->getContact()->getSiren();
    }
    
    /**
     * {@inheritdoc}
     */
    public function setNic($nic)
    {
    	$this->getContact()->setNic($nic);
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getNic()
    {
    	return $this->getContact()->getNic();
    }
    
    /**
     * {@inheritdoc}
     */
    public function addContact(CompanyPersonInterface $contacts)
    {
        $this->getContact()->addContact($contacts);
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeContact(CompanyPersonInterface $contacts)
    {
    	$this->getContact()->removeContact($contacts);
    	
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContacts()
    {
        return $this->getContact()->getContacts();
    }
}