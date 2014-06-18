<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JLM\InstallationBundle\Model\PartTypeInterface;

/**
 * JLM\ModelBundle\Entity\DoorType
 *
 * @ORM\Table(name="door_types")
 * @ORM\Entity
 */
class DoorType extends StringModel implements PartTypeInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}