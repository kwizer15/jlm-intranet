<?php
namespace JLM\InterventionBundle\Model;

use JLM\ModelBundle\Entity\StringModel;

/**
 * FixingInterface
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface FixingInterface extends InterventionInterface
{
	/**
	 * Get the ask
	 *
	 * @return AskInterface
	 */
	public function getAsk();
	
	/**
	 * Get the reason of the intervention
	 *
	 * @return string
	 */
	public function getReason();
	
	/**
	 * Get the observation
	 * 
	 * @return string
	 */
	public function getObservation();
}