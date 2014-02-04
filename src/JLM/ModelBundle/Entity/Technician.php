<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
	 * @Assert\Regex(pattern="/^\d{3,4}$/",message="Ce numéro ne contient pas uniquement 3 à 4 chiffres")
	 */
	private $internalPhone;
	
	public function __toString()
	{
		return $this->getFirstName();
	}
}