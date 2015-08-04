<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use JLM\ContactBundle\Model\AddressInterface;
use JLM\CondominiumBundle\Model\ManagerInterface;
use JLM\CondominiumBundle\Model\CondominiumInterface;
use JLM\CondominiumBundle\Model\AdministratorInterface;
use JLM\CondominiumBundle\Model\AdministratorMemberInterface;
use JLM\TransmitterBundle\Entity\UserGroup;
use JLM\CommerceBundle\Model\BillInterface;
use JLM\CommerceBundle\Model\VATInterface;
use JLM\CommerceBundle\Model\BusinessInterface;
use JLM\AskBundle\Model\SubjectInterface;
use JLM\ContactBundle\Entity\Company;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Site implements AdministratorInterface, BusinessInterface, SubjectInterface
{
    /**
     * @var integer $id
     */
    private $id;
    
    /**
     * @var boolean $accession
     * true = accession
     * false = social
     * 
     * @Assert\Choice(choices={0,1})
     * @Assert\NotNull
     */
    private $accession;
    
    /**
     * @var Address $address
     * 
     * @Assert\Valid
     * @Assert\NotNull
     */
    private $address;
    
    /**
     * @var string $groupnumber
     * 
     * @Assert\Length(min=4,max=6)
     */
    private $groupNumber;
    
    /**
     * @var ArrayCollection $doors
     */
    private $doors;
    
    /**
     * @var ArrayCollection $contacts
     */
    private $contacts;
    
    /**
     * @var ManagerInterface $trustee
     * 
     * @Assert\Valid
     * @Assert\NotNull
     */
    private $trustee;
    
    /**
     * @var VAT $vat
     * 
     * @Assert\Valid
     * @Assert\NotNull
     */
    private $vat;
    
    /**
     * @var Address $lodge
     *
     * @Assert\Valid
     */
    private $lodge;
    
    /**
     * @var string $observations
     *
     * @Assert\Type(type="string")
     */
    private $observations;
    
    /**
     * @var ArrayCollection
     */
    private $userGroups;
    
    /**
     * @var ArrayColection
     */
    private $bills;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->doors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->userGroups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bills = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param AddressInterface $address
     * @return Site
     */
    public function setAddress(AddressInterface $address = null)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set lodge
     *
     * @param AddresInterface $lodge
     * @return self
     */
    public function setLodge(AddressInterface $lodge = null)
    {
    	$this->lodge = $lodge;
    
    	return $this;
    }
    
    /**
     * Get lodge
     *
     * @return AddresInterface
     */
    public function getLodge()
    {
    	return $this->lodge;
    }
    
    /**
     * Set observations
     *
     * @param string $observations
     * @return self
     */
    public function setObservations($observations)
    {
    	$this->observations = $observations;
    
    	return $this;
    }
    
    /**
     * Get observations
     *
     * @return string
     */
    public function getObservations()
    {
    	return $this->observations;
    }
    
    /**
     * Set groupnumber
     * @param string
     * @return self
     */
    public function setGroupNumber($groupNumber)
    {
    	$this->groupNumber = $groupNumber;
    	
    	return $this;
    }
    
    /**
     * Get groupnumber
     * @return string
     */
    public function getGroupNumber()
    {
    	return $this->groupNumber;
    }
    
    /**
     * Add doors
     *
     * @param Door $doors
     * @return boolean
     */
    public function addDoor(Door $doors)
    {
        return $this->doors->add($doors);
    }

    /**
     * Remove doors
     *
     * @param Door $doors
     * @return boolean
     */
    public function removeDoor(Door $doors)
    {
        return $this->doors->removeElement($doors);
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
     * @deprecated
     * @param AdministratorMemberInterface $member
     * @return Site
     */
    public function addContact(AdministratorMemberInterface $member)
    {
        return $this->addMember($member);
    }

    /**
     * Remove contacts
     * @deprecated
     * @param AdministratorMemberInterface $member
     */
    public function removeContact(AdministratorMemberInterface $member)
    {
        return $this->removeMember($member);
    }

    /**
     * Get contacts
     * @deprecated
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->getMembers();
    }

    /**
     * Set trustee
     * @deprecated
     * @param JLM\ModelBundle\Entity\Trustee $trustee
     * @return Site
     */
    public function setTrustee(ManagerInterface $manager = null)
    {
        return $this->setManager($manager);
    }
    
    /**
     * Get trustee
     * @deprecated
     * @return JLM\ModelBundle\Entity\Trustee 
     */
    public function getTrustee()
    {
        return $this->getManager();
    }

    /**
     * Set vat
     *
     * @param VATInterface $vat
     * @return Site
     */
    public function setVat(VATInterface $vat = null)
    {
        $this->vat = $vat;
    
        return $this;
    }

    /**
     * Get vat
     *
     * @return VATInterface
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
    	return $this->getName();
    }
    
    /**
     * To String
     */
    public function toString()
    {
        if (!$this->getAddress() instanceof AddressInterface)
        {
            return '';
        }
    	return $this->getAddress()->toString();
    }
    
    /**
     * Get Billing Prelabel
     * @return string
     */
    public function getBillingPrelabel()
    {
    	$prelabel = '';
    	foreach ($this->getDoors() as $door)
    	{
    		if (!$prelabel)
    		{
    			return $door->getBillingPrelabel();
    		}
    	}
    	return '';
    }

    /**
     * Add userGroups
     *
     * @param \JLM\TransmitterBundle\Entity\UserGroup $userGroups
     * @return Site
     */
    public function addUserGroup(UserGroup $userGroups)
    {
        $this->userGroups[] = $userGroups;
    
        return $this;
    }

    /**
     * Remove userGroups
     *
     * @param \JLM\TransmitterBundle\Entity\UserGroup $userGroups
     */
    public function removeUserGroup(UserGroup $userGroups)
    {
        $this->userGroups->removeElement($userGroups);
    }

    /**
     * Get userGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserGroups()
    {
        return $this->userGroups;
    }

    /**
     * Add bills
     *
     * @param BillInterface $bills
     * @return Site
     */
    public function addBill(BillInterface $bills)
    {
        $this->bills[] = $bills;
    
        return $this;
    }

    /**
     * Remove bills
     *
     * @param BillInterface $bills
     */
    public function removeBill(BillInterface $bills)
    {
        $this->bills->removeElement($bills);
    }

    /**
     * Get bills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBills()
    {
        return $this->bills;
    }
    
    /**
     * Blocage des nouvelles intervs pour cause de retard de paiement
     * 
     * @return bool
     */
    public function isBlocked()
    {
    	$bills = $this->getBills();
    	foreach ($bills as $bill)
    	{
    		if ($bill->getState() == 1 && $bill->getSecondBoost() !== null)
    			return true;
    	}
    	return false;
    }
    
    /**
     * Blocage des nouvelles intervs pour cause de retard de paiement
     *
     * @return array
     */
    public function getUnpayedBills()
    {
    	$bills = $this->getBills();
    	$unpayed = array();
    	$date = new \DateTime;
    	foreach ($bills as $bill)
    	{
    		if ($bill->getState() == 1 && $bill->getMaturityDate() > $date)
    		{
    			$unpayed[] = $bill;
    		}
    	}
    	
    	return $unpayed;
    }
    
    public function getManagerContacts()
    {
    	$c = array();
    	$doors = $this->getDoors();
    	if ($doors === null)
    	{
    		return array();
    	}
    	foreach ($doors as $door)
    	{
    		$c = array_merge($c,$this->_createContactFromEmail($door->getManagerEmails()));
    	}
    	
    	return $c;
    }
    
    public function getBoostContacts()
    {
    	$c = array();
    	$doors = $this->getDoors();
    	if ($doors === null)
    	{
    		return array();
    	}
    	foreach ($doors as $door)
    	{
    		$c = array_merge($c,$this->_createContactFromEmail($door->getAccountingEmails()));
    	}
    	
    	return $c;
    }
    
    private function _createContactFromEmail($emails)
    {
    	$c = array();
    	if ($emails === null)
    	{
    		return $c;
    	}
    
    	foreach ($emails as $email)
    	{
    		$temp = new Company();
    		$temp->setEmail($email);
    		$c[] = $temp;
    	}
    
    	return $c;
    }
    
    
    // New
    
    /**
     * Set the manager
     * @param ManagerInterface $manager
     * @return self
     */
    public function setManager(ManagerInterface $manager = null)
    {
        $this->trustee = $manager;
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getManager()
    {
        return $this->trustee;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMembers()
    {
        return $this->contacts;
    }
    
    /**
     * Add contacts
     *
     * @param AdministratorMemberInterface $contacts
     * @return boolean
     */
    public function addMember(AdministratorMemberInterface $member)
    {
        return $this->contacts->add($member);
    }
    
    /**
     * Remove contacts
     *
     * @param AdministratorMemberInterface $contacts
     * @return boolean
     */
    public function removeMember(AdministratorMemberInterface $member)
    {
        return $this->contacts->removeElement($member);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getAddress()->__toString();
    }
    
    /**
     * 
     * @return number
     */
    public function getVatRate()
    {
        return $this->getVat()->getRate();
    }
    
    public function getBillingLabel()
    {
        return $this->getManager()->getBillingLabel();
    }
}