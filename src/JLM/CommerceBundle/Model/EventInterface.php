<?php
namespace JLM\CommerceBundle\Model;

interface EventInterface
{	
	/**
	 * @return \DateTime
	 */
	public function getDate();
	
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return string
	 */
	public function getOption($name, $default = null);
}