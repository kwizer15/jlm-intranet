<?php
namespace JLM\ProductBundle\Factory;

use JLM\ContactBundle\Entity\Company;

class ContactFactory
{
	/**
	 * @return Supplier
	 */
	public static function createSupplier()
	{
		return new Supplier(new Company());
	}

	private function __construct()
	{

	}

	private function __clone() {}
}