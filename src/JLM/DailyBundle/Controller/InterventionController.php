<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Entity\Work;
use JLM\DailyBundle\Entity\Shifting;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\ModelBundle\Entity\Door;
use JLM\OfficeBundle\Entity\Task;
use JLM\OfficeBundle\Entity\Bill;
use JLM\OfficeBundle\Entity\TaskType;
use JLM\OfficeBundle\Entity\AskQuote;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\DailyBundle\Form\Type\InterventionCancelType;

/**
 * Fixing controller.
 *
 * @Route("/intervention")
 */
class InterventionController extends Controller
{
	/**
	 * Finds and displays a Intervention entity.
	 *
	 * @Route("/", name="intervention")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('JLMDailyBundle:Intervention')
					   ->getPrioritary();
		return array(
				'entities'      => $entities,
		);
	}

	/**
	 * Bill intervention
	 *
	 * @Route("/{id}/tobill", name="intervention_tobill")
	 * @Secure(roles="ROLE_USER")
	 */
	public function tobillAction(Intervention $entity)
	{
		$entity->setMustBeBilled(true);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Don't Bill intervention
	 *
	 * @Route("/{id}/dontbill", name="intervention_dontbill")
	 * @Secure(roles="ROLE_USER")
	 */
	public function dontbillAction(Intervention $entity)
	{
		$entity->setMustBeBilled(false);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Cancel Bill action
	 *
	 * @Route("/{id}/cancelbill", name="intervention_cancelbill")
	 * @Secure(roles="ROLE_USER")
	 */
	public function cancelbillAction(Intervention $entity)
	{
		$em = $this->getDoctrine()->getManager();
		if ($entity->getMustBeBilled())
		{
			
			if ($entity->getBill() !== null)
			{
				// 	annuler la facture existante
				$bill = $entity->getBill();
				$bill->setIntervention();
				$bill->setState(-1);
				$entity->setBill();
				$em->persist($bill);
			}
			elseif ($entity->getExternalBill() !== null)
			{
				$entity->setExternalBill();
			}
		}
		$entity->setMustBeBilled(null);
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Crée une demande de devis
	 * @Route("/{id}/toquote", name="intervention_toquote")
	 * @Secure(roles="ROLE_USER")
	 */
	public function toquoteAction(Intervention $entity)
	{
		$ask = new AskQuote;
		$ask->populateFromIntervention($entity);
		$em = $this->getDoctrine()->getManager();
		$em->persist($ask);
		$entity->setAskQuote($ask);
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Supprime une demande de devis
	 * @Route("/{id}/cancelquote", name="intervention_cancelquote")
	 * @Secure(roles="ROLE_USER")
	 */
	public function cancelquoteAction(Intervention $entity)
	{
		if (($ask = $entity->getAskQuote()) !== null)
		{
			$ask->setIntervention();
			$entity->setAskQuote();
			$em = $this->getDoctrine()->getManager();
			$em->remove($ask);
			$em->persist($entity);
			$em->flush();
		}
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Active contacter client
	 * @Route("/{id}/tocontact", name="intervention_tocontact")
	 * @Secure(roles="ROLE_USER")
	 */
	public function tocontactAction(Intervention $entity)
	{
		$entity->setContactCustomer(false);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Supprime une demande de devis
	 * @Route("/{id}/cancelcontact", name="intervention_cancelcontact")
	 * @Secure(roles="ROLE_USER")
	 */
	public function cancelcontactAction(Intervention $entity)
	{
		$entity->setContactCustomer(null);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Créer un ligne travaux
	 * @Route("/{id}/towork", name="intervention_towork")
	 * @Secure(roles="ROLE_USER")
	 */
	public function toworkAction(Intervention $entity)
	{
		$em = $this->getDoctrine()->getManager();
		$workCat = $em->getRepository('JLMDailyBundle:WorkCategory')->find(1);
		$workObj = $em->getRepository('JLMDailyBundle:WorkObjective')->find(1);
		$work = new Work;
		$work->populateFromIntervention($entity);
		$work->setCategory($workCat);
		$work->setObjective($workObj);
		$em->persist($work);
		$entity->setWork($work);
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Supprime une ligne travaux
	 * @Route("/{id}/cancelwork", name="intervention_cancelwork")
	 * @Secure(roles="ROLE_USER")
	 */
	public function cancelworkAction(Intervention $entity)
	{
		$work = $entity->getWork();
		$entity->setWork();
		$em = $this->getDoctrine()->getManager();
		$em->remove($work);
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Annule l'intervention
	 * @Route("/{id}/cancel", name="intervention_cancel")
	 * @Secure(roles="ROLE_USER")
	 */
	public function cancelAction(Request $request, Intervention $entity)
	{
		$form = $this->createForm(new InterventionCancelType(), $entity);
		$form->bind($request);
		if ($form->isValid())
		{
			$entity->cancel();
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
		}
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Désannule l'intervention
	 * @Route("/{id}/uncancel", name="intervention_uncancel")
	 * @Secure(roles="ROLE_USER")
	 */
	public function uncancelAction(Request $request, Intervention $entity)
	{
		$entity->uncancel();
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Numéro de facture
	 * @Route("/{id}/externalbill", name="intervention_externalbill")
	 * @Method("POST")
	 * @Secure(roles="ROLE_USER")
	 */
	public function externalbillAction(Request $request, Intervention $entity)
	{
		$form = $this->createForm(new ExternalBillType(), $entity);
		$form->bind($request);
		if ($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
		}
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Route("/today", name="intervention_today")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function todayAction()
	{
		$today = new \DateTime;
		$todaystring =  $today->format('Y-m-d');
		$em = $this->getDoctrine()->getManager();
		$intervs = array_merge(
				$em->getRepository('JLMDailyBundle:Fixing')->getToday(),
				$em->getRepository('JLMDailyBundle:Work')->getToday(),
				$em->getRepository('JLMDailyBundle:Maintenance')->getToday()
			);
		$inprogress = $notclosed = $closed = array();
		foreach ($intervs as $interv)
		{
			$flag = false;
			if ($interv->getState() == 3)
			{
				$closed[] = $interv;
				$flag = true;
			}
			else
			{
				foreach ($interv->getShiftTechnicians() as $tech)
				{
					if ($tech->getBegin()->format('Y-m-d') == $todaystring && !$flag)
					{
						$inprogress[] = $interv;
						$flag = true;
					}
				}
			}
			if (!$flag)
				$notclosed[] = $interv;
		}

		return array(
				'inprogress' => $inprogress,
				'fixing' => $em->getRepository('JLMDailyBundle:Fixing')->getToGive(),
				'equipment' => $em->getRepository('JLMDailyBundle:Equipment')->getToday(),
				'notclosed' => $notclosed,
				'closed' => $closed,
		);	
	}
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Route("/list", name="intervention_list")
	 * @Route("/list/{date1}", name="intervention_listdate1")
	 * @Route("/list/{date1}/{date2}", name="intervention_listdate2")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function reportAction($date1 = null,$date2 = null)
	{
		$now = new \DateTime;
		$today = \DateTime::createFromFormat('YmdHis',$now->format('Ymd').'000000');
		$d1 = ($date1 === null) ? $today : \DateTime::createFromFormat('YmdHis',$date1.'000000');
		$d2 = ($date2 === null) ? \DateTime::createFromFormat('YmdHis',$d1->format('Ymd').'235959') : \DateTime::createFromFormat('YmdHis',$date2.'235959');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('JLMDailyBundle:Intervention');
		
		$intervs = $repo->getWithDate($d1,$d2);
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getWithDate($d1,$d2);
		$now->sub(new \DateInterval('P4D'));
		$days = array(
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
		);
		return array(
				'standby' => $em->getRepository('JLMDailyBundle:Standby')->getByDate($date1),
				'd1' => $d1,
				'd2' => ($date2 === null) ? null : $d2,
				'entities' => array_merge($equipment,$intervs),
				'days' => $days,
		);
	}
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Route("/listpost", name="intervention_list_post")
	 * @Method("post")
	 * @Secure(roles="ROLE_USER")
	 */
	public function reportdateAction(Request $request)
	{
		$date = \DateTime::createFromFormat('d/m/Y',$request->get('datepicker'));

		return $this->redirect($this->generateUrl('intervention_listdate1',array('date1'=>$date->format('Ymd'))));
	}
	
	
	/**
	 * Supprimer une intervention
	 *
	 * @Route("/delete/{id}", name="intervention_delete")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function deleteAction(Shifting $entity)
	{
		$em = $this->getDoctrine()->getManager();
		foreach ($entity->getShiftTechnicians() as $tech)
			$em->remove($tech);
			
		$em->remove($entity);
		$em->flush();
	
		return $this->redirect($this->generateUrl('intervention_today'));
	}
	
	/**
	 * Finds and displays a Intervention entity.
	 *
	 * @Route("/{id}/{act}", name="intervention_redirect", requirements={"id"="[0-9]+"})
	 * @Secure(roles="ROLE_USER")
	 */
	public function redirectAction(Intervention $entity, $act)
	{
		if (in_array($act,array('show','edit','close')))
			return $this->redirect($this->generateUrl($entity->getType() . '_' . $act,array('id'=>$entity->getId())));
		throw $this->createNotFoundException('Page inexistante');
	}
	
	/**
	 * Imprime les intervs de la prochaine journée
	 *
	 * @Route("/printday/{date1}", name="intervention_printday")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printdayAction($date1)
	{
		$now = new \DateTime;
		$today = \DateTime::createFromFormat('YmdHis',$now->format('Ymd').'000000');
		$d1 = \DateTime::createFromFormat('YmdHis',$date1.'000000');
		$d2 =  \DateTime::createFromFormat('YmdHis',$d1->format('Ymd').'235959');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('JLMDailyBundle:Intervention');
		
		$intervs = $repo->getWithDate($d1,$d2);
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getWithDate($d1,$d2);
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$d1->format('Y-m-d').'.pdf');
		$response->setContent($this->render('JLMDailyBundle:Intervention:printday.pdf.php',
				array('date' => $d1,
						'entities' => array_merge($equipment,$intervs),
						'standby' => $em->getRepository('JLMDailyBundle:Standby')->getByDate($date1),
				)));
		
		return $response;
	}
	
	/**
	 * Imprime les intervs de la prochaine journée
	 *
	 * @Route("/printtomorrow", name="intervention_printtomorrow")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printtomorrowAction()
	{
		$now = new \DateTime;
		$em = $this->getDoctrine()->getManager();
		
		do {
			$tomorrow = \DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000');
			$results = $em->getRepository('JLMDailyBundle:Standby')->getCountByDate($tomorrow->format('Y-m-d'));
		} while ($results);
		
		$intervs = $em->getRepository('JLMDailyBundle:Intervention')->getWithDate($tomorrow,$tomorrow);
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getWithDate($tomorrow,$tomorrow);
		$fixing = $em->getRepository('JLMDailyBundle:Fixing')->getToGive();	
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$tomorrow->format('Y-m-d').'.pdf');
		$response->setContent($this->render('JLMDailyBundle:Intervention:printtomorrow.pdf.php',
				array('date' => $tomorrow,
					'entities' => array_merge($equipment,$intervs,$fixing),
		)));
		
		return $response;
	}
	
	/**
	 * Imprime les intervs d'une intallation
	 *
	 * @Route("/printdoor/{id}", name="intervention_printdoor")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printdoorAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$door = $em->getRepository('JLMModelBundle:Door')->find($id);
		$shifts = array();
		foreach ($door->getInterventions() as $interv)
		{
			foreach($interv->getShiftTechnicians() as $shift)
				$shifts[(string)$shift->getBegin()->getTimestamp()] = $shift;
		}
		krsort($shifts);
		
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$door->getId().'.pdf');
		$response->setContent($this->render('JLMDailyBundle:Intervention:printdoor.pdf.php',
				array(
					  'door' => $door,
					  'entities' => $shifts,
				)));
		
		return $response;
	}
}
