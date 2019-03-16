<?php
namespace JLM\FeeBundle\Model;

use JLM\Bill\Model\BillFactoryInterface;

interface FeesFollowerInterface
{
    /**
     * La génération de redevance peut-elle être lancée ?
     * @return bool
     */
    public function isActive();
    
    /**
     * Set activation
     *
     * @param \DateTime $activation
     * @return FeesFollower
     */
    public function setActivation(\DateTime $date);
    
    /**
     * Get activation date
     * @return \DateTime
     */
    public function getActivation();
}
