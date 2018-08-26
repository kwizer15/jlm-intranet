<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\Factory\BillFactory;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\RequestEvent;
use JLM\DailyBundle\Builder\WorkBillBuilder;
use JLM\DailyBundle\Builder\InterventionBillBuilder;
use JLM\DailyBundle\Entity\Work;    // @todo Change to WorkInterface

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillSubscriber implements EventSubscriberInterface
{
   
    private $om;
    private $form;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromIntervention',
            JLMCommerceEvents::BILL_AFTER_PERSIST => 'setBillToIntervention',
        ];
    }
    
    public function populateFromIntervention(FormPopulatingEvent $event)
    {
        if (null !== $interv = $this->getIntervention($event)) {
            $builder = ($interv instanceof Work) ? (($interv->getQuote() !== null) ? new WorkBillBuilder($interv) : null) : null;
            $builder = ($builder === null) ? new InterventionBillBuilder($interv) : $builder;
            $entity = BillFactory::create($builder);
            $event->getForm()->setData($entity);
            $event->getForm()->add('intervention', 'hidden', ['data' => $interv->getId(), 'mapped' => false]);
        }
    }
    
    public function setBillToIntervention(BillEvent $event)
    {
        if (null !== $entity = $this->getIntervention($event)) {
            $entity->setBill($event->getBill());
            $this->om->persist($entity);
            $this->om->flush();
        }
    }
    
    private function getIntervention(RequestEvent $event)
    {
        $id = $event->getParam('jlm_commerce_bill', ['intervention'=>$event->getParam('intervention')]);
    
        return (isset($id['intervention']) && $id['intervention'] !== null) ? $this->om->getRepository('JLMDailyBundle:Intervention')->find($id['intervention']) : null;
    }
}
