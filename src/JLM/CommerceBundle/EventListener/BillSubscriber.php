<?php
namespace JLM\CommerceBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\Builder\VariantBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CommerceBundle\Event\BillEvent;

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
            JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromQuote',
            JLMCommerceEvents::BILL_BOOST_SENDMAIL => 'persistEmails',
        ];
    }
    
    public function populateFromQuote(FormPopulatingEvent $event)
    {
        if (null !== $id = $event->getParam('quote')) {
            $quote = $this->om->getRepository('JLMCommerceBundle:Quote')->find($id);
            $entity = BillFactory::create(new VariantBillBuilder($quote));
            $event->getForm()->setData($entity);
        }
    }
    
    public function persistEmails(BillEvent $event)
    {
        $bill = $event->getBill();
        $src = $bill->getSrc();
        $mail = $event->getParam('jlm_core_mail');
        $to = (isset($mail['to'])) ? $mail['to'] : [];
        $cc = (isset($mail['cc'])) ? $mail['cc'] : [];
        /**
         * Truc archaique pour sauver les adresses depuis la source
         */
        if (method_exists($src, 'setAccountingEmails')) {
            $src->setAccountingEmails($to);
        }
        if (method_exists($src, 'setManagerEmails')) {
            $src->setManagerEmails($cc);
        }
        if ($src !== null) {
            $this->om->persist($src);
            $this->om->flush();
        }
    }
}
