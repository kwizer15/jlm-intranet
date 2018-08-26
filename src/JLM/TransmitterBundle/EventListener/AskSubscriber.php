<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\QuoteVariantEvent;
use JLM\TransmitterBundle\Factory\AskFactory;
use JLM\TransmitterBundle\Builder\VariantAskBuilder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AskSubscriber implements EventSubscriberInterface
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
            JLMCommerceEvents::QUOTEVARIANT_GIVEN => 'createAskFromQuote',
        ];
    }
    
    /**
     * @param QuoteVariantEvent $event
     */
    public function createAskFromQuote(QuoteVariantEvent $event)
    {
        $entity = $event->getQuoteVariant();
        if ($entity->hasLineType('TRANSMITTER')) {
            $ask = AskFactory::create(new VariantAskBuilder($entity));
            $this->om->persist($ask);
            $this->om->flush();
        }
    }
}
