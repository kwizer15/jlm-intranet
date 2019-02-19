<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Entity\DoorStop;
use JLM\ModelBundle\Form\Type\DoorStopEditType;

/**
 * Fixing controller.
 */
class DoorController extends Controller
{
    /**
     * Finds and displays a Door entity.
     *
     * @Template()
     */
    public function showAction(Door $door)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        
        $codeForm = $this->createCodeForm($door);
        
        return [
                'entity'   => $door,
                'quotes'   => $em->getRepository('JLMCommerceBundle:Quote')->getByDoor($door),
                'codeForm' => $codeForm->createView(),
               ];
    }
    
    private function createCodeForm(Door $door)
    {
        $form = $this->createForm(
            new \JLM\ModelBundle\Form\Type\DoorTagType(),
            $door,
            [
             'action' => $this->generateUrl('model_door_update_code', ['id' => $door->getId()]),
             'method' => 'POST',
            ]
        );
                    
        return $form;
    }
    
    /**
     * Displays Doors stopped
     *
     * @Template()
     */
    public function stoppedAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $doors = $em->getRepository('JLMModelBundle:Door')->getStopped();
        $stopForms = [];
        
        foreach ($doors as $door) {
            $stopForms[] = $this->get('form.factory')->createNamed(
                'doorStopEdit'.$door->getLastStop()->getId(),
                new DoorStopEditType(),
                $door->getLastStop()
            )->createView();
        }
        
        return [
                'entities'  => $doors,
                'stopForms' => $stopForms,
               ];
    }
    
    /**
     * Displays Doors stopped
     *
     * @Template("JLMDailyBundle:Door:stopped.html.twig")
     */
    public function stopupdateAction(Request $request, DoorStop $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->get('form.factory')->createNamed(
            'doorStopEdit'.$entity->getId(),
            new DoorStopEditType(),
            $entity
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
        return $this->stoppedAction();
    }
    
    /**
     * Displays Doors stopped
     *
     * @Template()
     */
    public function printstoppedAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $doors = $em->getRepository('JLMModelBundle:Door')->getStopped();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=portes-arret.pdf');
        $response->setContent($this->render(
            'JLMDailyBundle:Door:printstopped.pdf.php',
            ['entities' => $doors]
        ));
        return $response;
    }
    
    /**
     * Stop door
     *
     * @Template("JLMDailyBundle:Door:show.html.twig")
     */
    public function stopAction(Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        if ($entity->getLastStop() === null) {
            $stop = new DoorStop;
            $stop->setBegin(new \DateTime);
            $stop->setReason('À définir');
            $stop->setState('Non traitée');
            $entity->addStop($stop);
            $em->persist($stop);
            $em->flush();
        }
        return $this->showAction($entity);
    }
    
    /**
     * Unstop door
     *
     * @Template("JLMDailyBundle:Door:show.html.twig")
     */
    public function unstopAction(Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $stop = $entity->getLastStop();
        if ($stop === null) {
            return $this->showAction($entity);
        }
        $stop->setEnd(new \DateTime);
        $em->persist($stop);
        $em->flush();
        return $this->showAction($entity);
    }
}
