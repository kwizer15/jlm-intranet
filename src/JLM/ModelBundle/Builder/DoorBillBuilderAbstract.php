<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Builder;

use JLM\ModelBundle\Entity\Door;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class DoorBillBuilderAbstract extends SiteBillBuilderAbstract
{
	/**
	 * @return Door
	 */
    abstract protected function _getDoor();
    
    /**
     * {@inheritdoc}
     */
    protected function _getSite()
    {
        return $this->_getDoor()->getSite();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getTrustee()
    {
        $contract = $this->_getDoor()->getActualContract();
        return (empty($contract)) ? $this->_getDoor()->getSite()->getTrustee() : $contract->getTrustee();
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildDetails()
    {
        $door = $this->_getDoor();
        $this->getBill()->setDetails($door->getType().' - '.$door->getLocation());
    }
}