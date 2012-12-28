<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ModelBundle\Entity\StringModel;

/**
 * JLM\DailyBundle\Entity\WorkObjective
 *
 * @ORM\Table(name="work_objectives")
 * @ORM\Entity(readOnly=true)
 */
class WorkObjective extends StringModel
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
