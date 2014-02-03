<?php
namespace JLM\ContactBundle\Model;

interface ContactInterface
{
	/**
	 * Get name
	 * @return string
	 */
	public function getName();
	
	/**
	 * Get name
	 * @return string
	 */
	public function __toString();
	
	/**
	 * Add an Email
	 * @param EmailInterface $email
	 * @return self
	 */
	public function addEmail(ContactEmailInterface $email);
	
	/**
	 * Remove an Email
	 * @param EmailInterface $email
	 * @return self
	 */
	public function removeEmail(ContactEmailInterface $email);
	
	/**
	 * get Emails
	 * @return array
	 */
	public function getEmails();
	
	/**
	 * Add an Address
	 * @param AddressInterface $address
	 * @return self
	 */
	public function addAddress(ContactAddressInterface $address);
	
	/**
	 * Remove an Address
	 * @param AddressInterface $address
	 * @return self
	 */
	public function removeAddress(ContactAddressInterface $address);
	
	/**
	 * Get Addresses
	 * @return array
	 */
	public function getAddresses();
	
	/**
	 * Get Main Address
	 * @return AddressInterface
	 */
	public function getMainAddress();
	
	/**
	 * Add a Phone
	 * @param PhoneInterface $phone
	 * @return self
	 */
	public function addPhone(ContactPhoneInterface $phone);
	
	/**
	 * Remove a Phone
	 * @param PhoneInterface $phone
	 * @return self
	 */
	public function removePhone(ContactPhoneInterface $phone);
	
	/**
	 * Get Phones
	 * @return array
	 */
	public function getPhones();
}