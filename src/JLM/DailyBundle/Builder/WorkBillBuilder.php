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

use JLM\DailyBundle\Entity\Work;
use JLM\CommerceBundle\Builder\VariantBillBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class WorkBillBuilder extends VariantBillBuilder
{
    private $intervention;
    
    /**
     *
     * @param Work $intervention
     * @throws LogicException
     */
    public function __construct(Work $intervention, $options = [])
    {
        if ($intervention->getQuote() === null) {
            throw new LogicException('Aucun devis lié a ces travaux');
        }
        parent::__construct($intervention->getQuote(), $options);
        $this->intervention = $intervention;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        parent::buildReference();
        $ref = $this->getBill()->getReference();
        $this->getBill()->setReference($ref.' et notre intervention du '.$this->intervention->getLastDate()->format('d/m/Y'));
        $this->getBill()->setIntervention($this->intervention);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildIntro()
    {
        $this->getBill()->setIntro($this->intervention->getReason());
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getDoor()
    {
        return $this->intervention->getDoor();
    }
}
