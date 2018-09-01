<?php

namespace JLM\CommerceBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\Builder\VariantBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\DoctrineEvent;
use JLM\CommerceBundle\Event\QuoteVariantEvent;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use JLM\CommerceBundle\Builder\Email\QuoteVariantConfirmGivenMailBuilder;

class QuoteVariantSubscriber implements EventSubscriberInterface
{

    private $om;
    private $mailer;

    public function __construct(ObjectManager $om, $mailer)
    {
        $this->om = $om;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            JLMCommerceEvents::QUOTEVARIANT_FORM_POPULATE => 'populateFromQuote',
            JLMCommerceEvents::QUOTEVARIANT_PREPERSIST => 'generateNumber',
            // JLMCommerceEvents::QUOTEVARIANT_GIVEN => 'sendGivenConfirmMail',
        ];
    }

    public function populateFromQuote(FormPopulatingEvent $event)
    {
        if (null !== $id = $event->getFormParam('quote_variant', 'quote')) {
            $quote = $this->om->getRepository('JLMCommerceBundle:Quote')->find($id);
            $event->getForm()->get('quote')->setData($quote);
        }
    }

    public function generateNumber(DoctrineEvent $event)
    {
        $number = $this->om
            ->getRepository('JLMCommerceBundle:QuoteVariant')
            ->getCount($event->getEntity()->getQuote()) + 1;
        $event->getEntity()->setVariantNumber($number);
    }

    public function sendGivenConfirmMail(QuoteVariantEvent $event)
    {
        $mail = MailFactory::create(new QuoteVariantConfirmGivenMailBuilder($event->getQuoteVariant()));
        $swift = MailFactory::create(new MailSwiftMailBuilder($mail));
        $this->mailer->send($swift);
    }
}
