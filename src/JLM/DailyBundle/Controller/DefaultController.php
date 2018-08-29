<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Form\Type\FixingType;
use JLM\CoreBundle\Entity\Search;

class DefaultController extends Controller
{
    /**
     * Search
     * @Secure(roles="ROLE_OFFICE")
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $formData = $request->get('jlm_core_search');
         
        if (is_array($formData) && array_key_exists('query', $formData)) {
            $em = $this->getDoctrine()->getManager();
            $doors = $em->getRepository('JLMModelBundle:Door')->search($formData['query']);

            /*
             * Voir aussi
            *   DoorController:stoppedAction
            *   FixingController:newAction -> utiliser formModal
            * @todo A factoriser de là ...
            */
            $fixingForms = [];
            foreach ($doors as $door) {
                $form = new Fixing();
                $form->setDoor($door);
                $form->setAskDate(new \DateTime);
                $fixingForms[] = $this->get('form.factory')->createNamed(
                    'fixingNew'.$door->getId(),
                    new FixingType(),
                    $form
                )->createView();
            }
            /* à la */
            return [
                    'query'        => $formData['query'],
                    'doors'        => $doors,
                    'fixing_forms' => $fixingForms,
                   ];
        }
        return [];
    }
    
    /**
     * Search
     * @Secure(roles="ROLE_OFFICE")
     * @deprecated
     */
    public function searchgetAction(Request $request)
    {
        return $this->redirect($this->generateUrl('intervention_today'));
    }
    
    /**
     * Sidebar
     * @Secure(roles="ROLE_OFFICE")
     * @Template()
     * @deprecated Use the TwigExtension
     */
    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getManager();
        return [
                'today'       => $em->getRepository('JLMDailyBundle:Intervention')->getCountToday(),
                'stopped'     => $em->getRepository('JLMModelBundle:Door')->getCountStopped(),
                'fixing'      => $em->getRepository('JLMDailyBundle:Fixing')->getCountOpened(),
                'work'        => $em->getRepository('JLMDailyBundle:Work')->getCountOpened(),
                'maintenance' => $em->getRepository('JLMDailyBundle:Maintenance')->getCountOpened(),
               ];
    }
    
    /**
     * Search by date form
     * @Secure(roles="ROLE_OFFICE")
     * @Template()
     */
    public function datesearchAction()
    {
        $entity = new \DateTime();
        $form   = $this->createForm(new DatepickerType(), $entity);
        return [
                'form' => $form->createView(),
               ];
    }
}
