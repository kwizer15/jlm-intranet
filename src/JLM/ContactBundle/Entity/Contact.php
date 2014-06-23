<?php

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\ContactInterface;
use JLM\ContactBundle\Model\ContactDataInterface;
use JLM\ContactBundle\Model\ContactAddressInterface;
use JLM\ContactBundle\Model\ContactPhoneInterface;
use JLM\ContactBundle\Model\ContactEmailInterface;

/**
 * Contact
 */
abstract class Contact implements ContactInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $datas;
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->datas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add a contactData
     * @param ContactDataInterface $data
     * @return self
     */
    private function addContactData(ContactDataInterface $data)
    {
    	$data->setContact($this);
    	$this->datas[] = $data;
    	
    	return $this;
    }
    
    /**
     * Remove a contactData
     * @param ContactDataInterface $data
     * @return self
     */
    private function removeContactData(ContactDataInterface $data)
    {
    	$data->setContact();
    	$this->datas->removeElement($data);
    	
    	return $this;
    }
    
    private function getDatas($type)
    {
    	$datas = array();
    	foreach ($this->datas as $data)
    	{
    		if ($data instanceof $type)
    		{
    			$datas[] = $data;
    		}
    	}
    	return $datas;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addEmail(ContactEmailInterface $email)
    {
        return $this->addContactData($email);
    }

    /**
     * {@inheritdoc}
     */
    public function removeEmail(ContactEmailInterface $email)
    {
    	return $this->removeContactData($email);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmails()
    {
        return $this->getDatas('JLM\ContactBundle\Model\ContactEmailInterface');
    }

    /**
     * {@inheritdoc}
     */
    public function addPhone(ContactPhoneInterface $phone)
    {
    	return $this->addContactData($phone);
    }

    /**
     * {@inheritdoc}
     */
    public function removePhone(ContactPhoneInterface $phone)
    {
    	return $this->removeContactData($phone);
    }

    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
        return $this->getDatas('JLM\ContactBundle\Model\ContactPhoneInterface');
    }

    /**
     * {@inheritdoc}
     */
    public function addAddress(ContactAddressInterface $address)
    {
    	return $this->addContactData($address);
    }

    /**
     * {@inheritdoc}
     */
    public function removeAddress(ContactAddressInterface $address)
    {
    	return $this->removeContactData($address);
    }

    /**
     * {@inheritdoc}
     */
    public function getAddresses()
    {
        return $this->getDatas('JLM\ContactBundle\Model\ContactAddressInterface');
    }
    
    public function getMainAddress()
    {
    	$addresses = $this->getAddresses();
    	foreach ($addresses as $address)
    		if ($address->isMain())
    			return $address;
    	return null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    	return $this->getName();
    }
}