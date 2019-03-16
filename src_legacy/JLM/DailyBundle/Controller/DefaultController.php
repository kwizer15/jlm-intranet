<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Form\Type\FixingType;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * Search
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function searchAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
                    FixingType::class,
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
     *
     * @deprecated
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function searchgetAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return $this->redirect($this->generateUrl('intervention_today'));
    }
    
    /**
     * Sidebar
     * @Template()
     * @deprecated Use the TwigExtension
     */
    public function sidebarAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
     * @Template()
     */
    public function datesearchAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new \DateTime();
        $form   = $this->createForm(DatepickerType::class, $entity);
        return [
                'form' => $form->createView(),
               ];
    }
}
