<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Technician
 *
 * @ORM\Table(name="technicians")
 * @ORM\Entity
 */
class Technician extends Person
{
	/**
	 * @var string $internalPhone
	 *
	 * @ORM\Column(name="internalPhone",type="string", length=20, nullable=true)
	 */
	private $internalPhone;
	
	public function __toString()
	{
		return $this->getFirstName();
	}
}