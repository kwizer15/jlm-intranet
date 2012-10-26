<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Transmitter
 *
 * @ORM\Table(name="transmitters")
 * @ORM\Entity
 */
class Transmitter extends Product
{
	/**
	 * @todo Tarification
	 */
}