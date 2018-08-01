<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\ContractBundle\JLMContractEvents;
use JLM\ContractBundle\Event\ContractEvent;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\FeeBundle\Entity\Fee;

class ContractSubscriber implements EventSubscriberInterface
{
    public function __construct(ObjectManager $om)
    {
    	$this->om = $om;
    }

    public static function getSubscribedEvents()
    {
        return array(
            JLMContractEvents::AFTER_CONTRACT_CREATE => 'feeCreate'
        );
    }

    public function feeCreate(ContractEvent $event)
    {
        $entity = $event->getContract();
        if ($entity->getInProgress())
        {	 
        	$fee = new Fee();
        	$fee->addContract($entity);
        	$fee->setTrustee($entity->getTrustee());
        	$fee->setAddress($entity->getDoor()->getSite()->getAddress()->toString());
        	$fee->setPrelabel($entity->getDoor()->getSite()->getBillingPrelabel());
        	$fee->setVat($entity->getDoor()->getSite()->getVat());
        	$this->om->persist($fee);
        	$this->om->flush();
        }
    }
}