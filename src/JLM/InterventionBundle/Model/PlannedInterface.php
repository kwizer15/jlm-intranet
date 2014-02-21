<?php
namespace JLM\InterventionBundle\Model;

/**
 * PlannedShiftingInterface
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface PlannedInterface
{
	/**
	 * Get the planning
	 *
	 * @return \DateTime
	 */
	public function getPlanning();

	/**
	 * Valid the planning
	 *
	 * @return self
	*/
	public function validPlanning();
}