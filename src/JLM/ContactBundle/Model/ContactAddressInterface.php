<?php
namespace JLM\ContactBundle\Model;

interface ContactAddressInterface extends ContactDataInterface, AddressInterface
{
	/**
	 * is Main address
	 * @return bool
	 */
	public function isMain();
}