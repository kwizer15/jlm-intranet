<?php

namespace JLM\DailyBundle\Entity;

use JLM\ModelBundle\Entity\StringModel;

/**
 * JLM\DailyBundle\Entity\FixingDone
 */
class FixingDone extends StringModel
{
    /**
     * @var integer $id
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
