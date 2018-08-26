<?php
namespace JLM\ModelBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\ModelBundle\Builder\DoorBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;

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
            JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromDoor',
        ];
    }
    
    public function populateFromDoor(FormPopulatingEvent $event)
    {
        if (null !== $id = $event->getParam('installation')) {
            $install = $this->om->getRepository('JLMModelBundle:Door')->find($id);
            $entity = BillFactory::create(new DoorBillBuilder($install));
            $event->getForm()->setData($entity);
        }
    }
}
