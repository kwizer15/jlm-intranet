<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder;

use JLM\ModelBundle\Builder\DoorBillBuilderAbstract;
use JLM\DailyBundle\Entity\Intervention;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionBillBuilder extends DoorBillBuilderAbstract
{
    private $intervention;
    
    public function __construct(Intervention $intervention, $options = [])
    {
        $this->intervention = $intervention;
        parent::__construct($this->intervention->getDoor(), $options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        $this->getBill()->setReference(
            'Selon notre intervention du '.$this->intervention->getLastDate()->format('d/m/Y')
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildIntro()
    {
        $this->getBill()->setIntro($this->intervention->getReason());
    }
}
