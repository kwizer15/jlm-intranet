<?php
namespace JLM\ProductBundle\Model;

interface WeightInterface
{
	/**
	 * Get the weight
	 *
	 * @return decimal
	 */
	public function getWeight();
	
	/**
	 * Set the weight
	 *
	 * @return self
	 */
	public function setWeight($weight);
}