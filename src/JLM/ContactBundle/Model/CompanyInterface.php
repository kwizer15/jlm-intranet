<?php
namespace JLM\ContactBundle\Model;

interface CompanyInterface extends ContactInterface
{
	/**
	 * Set name
	 * @param string
	 * @return self
	 */
	public function setName($name);
	
	/**
	 * Set siret
	 * @param string
	 * @return self
	 */
	public function setSiret($siret);
	
	/**
	 * Get siret
	 * @return string
	 */
	public function getSiret();
	
	/**
	 * Set siren
	 * @param string $siren
	 * @throws CompanyException
	 * @return self
	 */
	public function setSiren($siren);
	
	/**
	 * Get siret
	 * @return string
	 */
	public function getSiren();
	
	/**
	 * Set nic
	 * @param string $nic
	 * @throws CompanyException
	 * @return self
	 */
	public function setNic($nic);
	
	/**
	 * Get nic
	 * @return string
	 */
	public function getNic();
	
	/**
	 * Add contacts
	 *
	 * @param PersonInterface $contacts
	 * @return self
	 */
	public function addContact(PersonInterface $contacts);
	
	/**
	 * Remove contacts
	 *
	 * @param PersonInterface $contacts
	 * @return self
	 */
	public function removeContact(PersonInterface $contacts);
	
	/**
	 * Get contacts
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getContacts();
}