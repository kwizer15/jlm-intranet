<?php
namespace JLM\BillBundle\Model;

interface BillableContact
{
	/**
	 * Get billing name
	 * @return string
	 */
	public function getBillingName();
	
	/**
	 * Get billing address
	 * @return string
	 */
	public function getBillingAddress();
	
}