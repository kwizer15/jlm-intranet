<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Form\Type\AddTechnicianType;
use JLM\DailyBundle\Form\Type\ShiftingEditType;
use JLM\DailyBundle\Form\Type\FixingType;
use JLM\DailyBundle\Form\Type\FixingEditType;
use JLM\DailyBundle\Form\Type\FixingCloseType;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\DailyBundle\Form\Type\InterventionCancelType;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Entity\DoorStop;
use Symfony\Component\HttpFoundation\JsonResponse;
use JLM\CoreBundle\Form\Type\MailType;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\DailyBundle\Builder\FixingTakenMailBuilder;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JLM\DailyBundle\JLMDailyBundle;
use JLM\ModelBundle\JLMModelEvents;
use JLM\ModelBundle\Event\DoorEvent;

/**
 * Fixing controller.
 */
class FixingController extends AbstractInterventionController
{
    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMDailyBundle:Fixing')->getPrioritary();
        return ['entities' => $entities];
    }
    
    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function emailAction(Fixing $entity, $step)
    {
        $request = $this->getRequest();
        $steps = [
                  'taken'       => 'JLM\DailyBundle\Builder\Email\FixingTakenMailBuilder',
                  'distributed' => 'JLM\DailyBundle\Builder\Email\FixingDistributedMailBuilder',
                  'onsite'      => 'JLM\DailyBundle\Builder\Email\FixingOnSiteMailBuilder',
                  'end'         => 'JLM\DailyBundle\Builder\Email\FixingEndMailBuilder',
                  'report'      => 'JLM\DailyBundle\Builder\Email\FixingReportMailBuilder',
                 ];
        $class = (array_key_exists($step, $steps)) ? $steps[$step] : null;
        if (null === $class) {
            throw new NotFoundHttpException('Page inexistante');
        }
        $mail = MailFactory::create(new $class($entity));
        $editForm = $this->createForm(new MailType(), $mail);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $this->get('mailer')->send(MailFactory::create(new MailSwiftMailBuilder($editForm->getData())));
            $this
                ->get('event_dispatcher')
                ->dispatch(JLMModelEvents::DOOR_SENDMAIL, new DoorEvent($entity->getDoor(), $request))
            ;

            return $this->redirect($this->generateUrl('fixing_show', ['id' => $entity->getId()]));
        }

        return [
                'entity' => $entity,
                'form'   => $editForm->createView(),
                'step'   => $step,
               ];
    }
    
    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function showAction(Fixing $entity)
    {

        return $this->show($entity);
    }
    
    /**
     * Displays a form to create a new InterventionPlanned entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function newAction(Door $door)
    {
        /*
      * Voir aussi
      *   DoorController:stoppedAction
       *   DefaultController:searchAction
     * @todo A factoriser
       */
        $entity = new Fixing();
        $entity->setDoor($door);
        $entity->setAskDate(new \DateTime);
        $form = $this->get('form.factory')->createNamed('fixingNew'.$door->getId(), new FixingType(), $entity);
        return [
                'door'   => $door,
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }
    
    /**
     * Creates a new InterventionPlanned entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function createAction(Request $request, Door $door)
    {
        $entity  = new Fixing();
        $entity->setCreation(new \DateTime);
        $entity->setDoor($door);
        $entity->setContract($door->getActualContract());
        $entity->setPlace($door.'');
        $entity->setPriority(2);
        $form = $this->get('form.factory')->createNamed('fixingNew'.$door->getId(), new FixingType(), $entity);
        $form->handleRequest($request);
    
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['id' => $entity->getId()]);
            }
            return $this->redirect($this->generateUrl('fixing_show', ['id' => $entity->getId()]));
        }
    
        return [
                'door'   => $door,
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }
    
    /**
     * Displays a form to edit an existing Fixing entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function editAction(Fixing $entity)
    {
        $editForm = $this->createForm(new FixingEditType(), $entity);
    
        return [
                'entity' => $entity,
                'form'   => $editForm->createView(),
               ];
    }
    
    /**
     * Edits an existing Fixing entity.
     *
     * @Template("JLMDailyBundle:Fixing:edit.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function updateAction(Request $request, Fixing $entity)
    {
        $editForm = $this->createForm(new FixingEditType(), $entity);
        $editForm->handleRequest($request);
    
        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('fixing_show', ['id' => $entity->getId()]));
        }
    
        return [
                'entity' => $entity,
                'form'   => $editForm->createView(),
               ];
    }
    
    /**
     * Close an existing Fixing entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function closeAction(Fixing $entity)
    {
        $form = $this->createForm(new FixingCloseType(), $entity);
    
        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }
    
    /**
     * Close an existing Fixing entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function closeupdateAction(Request $request, Fixing $entity)
    {
        $form = $this->createForm(new FixingCloseType(), $entity);
        $form->handleRequest($request);
    
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Mise à l'arrêt
            if ($entity->getDone()->getId() == 3) {
                $stop = $entity->getDoor()->getLastStop();
                if ($stop === null) {
                    $stop = new DoorStop;
                    $stop->setBegin(new \DateTime);
                    $stop->setState('Non traitée');
                }
                $stop->setReason($entity->getReport());
                $entity->getDoor()->addStop($stop);
                $em->persist($stop);
            }
            
            $entity->setClose(new \DateTime);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('fixing_show', ['id' => $entity->getId()]));
        }
    
        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }
    
    /**
     * Imprime le rapport d'intervention
     *
     * @Secure(roles="ROLE_OFFICE")
     */
    public function printdayAction(Fixing $entity)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=report-'.$entity->getId().'.pdf');
        $response->setContent($this->render(
            'JLMDailyBundle:Fixing:printreport.pdf.php',
            ['entity' => $entity]
        ));
    
        return $response;
    }
}
