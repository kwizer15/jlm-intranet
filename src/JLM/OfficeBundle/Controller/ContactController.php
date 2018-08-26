<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Intervention;

/**
 * Actions controller.
 *
 * @Route("/tocontact")
 */
class ContactController extends Controller
{

    
    /**
     * @Route("/", name="tocontact")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('JLMDailyBundle:Intervention')->getToContact();
        return ['entities'=>$list];
    }
    
    /**
     * @Route("/tocontact/contacted/{id}", name="tocontact_contacted")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function contactedAction(Intervention $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $entity->setContactCustomer(true);
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('tocontact'));
    }
}
