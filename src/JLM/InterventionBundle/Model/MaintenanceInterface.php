<?php
namespace JLM\InterventionBundle\Model;

/**
 * MaintenanceInterface
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface MaintenanceInterface extends InterventionInterface
{
	/**
	 * Get the observation
	 *
	 * @return string
	 */
	public function getObservation();
}