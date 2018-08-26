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
use JLM\DailyBundle\JLMDailyEvents;
use JLM\DailyBundle\Builder\InterventionWorkBuilder;
use JLM\DailyBundle\Event\InterventionEvent;
use JLM\DailyBundle\Factory\WorkFactory;
use JLM\CommerceBundle\Event\QuoteVariantEvent;
use JLM\DailyBundle\Entity\Work;
use JLM\OfficeBundle\Entity\Order;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\OfficeBundle\Factory\OrderFactory;
use JLM\DailyBundle\Builder\VariantWorkBuilder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class InterventionSubscriber implements EventSubscriberInterface
{
   
    /**
     * @var ObjectManager
     */
    private $om;
    
    /**
     * Constructor
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            JLMDailyEvents::INTERVENTION_SCHEDULEWORK => 'createWorkFromIntervention',
            JLMDailyEvents::INTERVENTION_UNSCHEDULEWORK => 'deleteWorkFromIntervention',
            JLMCommerceEvents::QUOTEVARIANT_GIVEN => 'createWorkFromQuote',
        ];
    }
    
    /**
     * Create work since intervention
     * @param InterventionEvent $event
     */
    public function createWorkFromIntervention(InterventionEvent $event)
    {
        $interv = $event->getIntervention();
        $options = [
                'category' => $this->om->getRepository('JLMDailyBundle:WorkCategory')->find(1),
                'objective' => $this->om->getRepository('JLMDailyBundle:WorkObjective')->find(1),
        ];
        $work = WorkFactory::create(new InterventionWorkBuilder($interv, $options));
        $this->om->persist($work);
        $interv->setWork($work);
        $this->om->persist($interv);
        $this->om->flush();
    }
    
    /**
     * Create work since intervention
     * @param InterventionEvent $event
     */
    public function deleteWorkFromIntervention(InterventionEvent $event)
    {
        $interv = $event->getIntervention();
        $work = $interv->getWork();
        $interv->setWork();
        if ($work !== null) {
            $this->om->remove($work);
            $this->om->persist($interv);
            $this->om->flush();
        }
    }
    
    /**
     * @param QuoteVariantEvent $event
     */
    public function createWorkFromQuote(QuoteVariantEvent $event)
    {
        $entity = $event->getQuoteVariant();
        if ($entity->getWork() === null && $entity->getQuote()->getDoor() !== null) {
            // Création de la ligne travaux pré-remplie
            //$work = Work::createFromQuoteVariant($entity);
            $work = WorkFactory::create(new VariantWorkBuilder($entity, [
                    'category' => $this->om->getRepository('JLMDailyBundle:WorkCategory')->find(1),
                    'objective' => $this->om->getRepository('JLMDailyBundle:WorkObjective')->find(1),
            ]));
            //$work->setMustBeBilled(true);
            //$work->setCategory($this->om->getRepository('JLMDailyBundle:WorkCategory')->find(1));
            //$work->setObjective($this->om->getRepository('JLMDailyBundle:WorkObjective')->find(1));
            $order = $work->getOrder();
            $this->om->persist($order);
            $olines = $order->getLines();
            foreach ($olines as $oline) {
                $oline->setOrder($order);
                $this->om->persist($oline);
            }
            //$work->setOrder($order);
            $this->om->persist($work);
            $entity->setWork($work);
            $this->om->flush();
        }
    }
}
