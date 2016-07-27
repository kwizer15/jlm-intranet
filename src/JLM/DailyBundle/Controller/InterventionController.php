<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Entity\Work;
use JLM\DailyBundle\Entity\Shifting;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\DailyBundle\Form\Type\InterventionCancelType;
use JLM\DailyBundle\JLMDailyEvents;
use JLM\DailyBundle\Event\InterventionEvent;
use JLM\DailyBundle\Factory\WorkFactory;
use JLM\DailyBundle\Builder\InterventionWorkBuilder;

use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\ModelBundle\Entity\Door;
use JLM\CommerceBundle\Entity\Bill;
use JLM\OfficeBundle\Entity\AskQuote;

/**
 * Fixing controller.
 */
class InterventionController extends Controller
{
	/**
	 * Finds and displays a Intervention entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function toworkAction(Intervention $entity)
	{
		$this->get('event_dispatcher')->dispatch(JLMDailyEvents::INTERVENTION_SCHEDULEWORK, new InterventionEvent($entity));
		
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Supprime une ligne travaux
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function cancelworkAction(Intervention $entity)
	{
		$this->get('event_dispatcher')->dispatch(JLMDailyEvents::INTERVENTION_UNSCHEDULEWORK, new InterventionEvent($entity));
		
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Annule l'intervention
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function cancelAction(Request $request, Intervention $entity)
	{
		$form = $this->createForm(new InterventionCancelType(), $entity);
		$form->handleRequest($request);
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
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function externalbillAction(Request $request, Intervention $entity)
	{
		//$form = $this->createForm(new ExternalBillType(), $entity);
		$form = $this->get('form.factory')->createNamed('externalBill'.$entity->getId(),new ExternalBillType(), $entity);
		$form->handleRequest($request);
		if ($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
		}

		return $this->redirect($request->headers->get('referer'));
	}
	
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
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
		$inprogress = $notclosed = $closed = $ago = array();
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
					elseif ($tech->getBegin()->getTimestamp() >= $today->getTimestamp() && !$flag)
					{
						$ago[] = $interv;
						$flag = true;
					}
				}
			}
			if (!$flag)
			{
				$notclosed[] = $interv;
			}
		}

		return array(
				'inprogress' => $inprogress,
				'fixing' => $em->getRepository('JLMDailyBundle:Fixing')->getToGive(),
				'equipment' => $em->getRepository('JLMDailyBundle:Equipment')->getToday(),
				'notclosed' => $notclosed,
				'closed' => $closed,
				'ago' => $ago,
		);	
	}
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
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
				'layout' => array('form_searchByDate_date' => $d1)
		);
	}
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function reportdateAction(Request $request)
	{
		$date = \DateTime::createFromFormat('d/m/Y',$request->get('datepicker'));

		return $this->redirect($this->generateUrl('intervention_listdate1',array('date1'=>$date->format('Ymd'))));
	}
	
	
	/**
	 * Supprimer une intervention
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function deleteAction(Shifting $entity)
	{
		$em = $this->getDoctrine()->getManager();
		foreach ($entity->getShiftTechnicians() as $tech)
		{
			$em->remove($tech);
		}	
		$em->remove($entity);
		$em->flush();
	
		return $this->redirect($this->generateUrl('intervention_today'));
	}
	
	/**
	 * Finds and displays a Intervention entity.
	 *
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function redirectAction(Intervention $entity, $act)
	{
		if (!in_array($act,array('show','edit','close')))
		{
			throw $this->createNotFoundException('Page inexistante');
		}
		
		return $this->redirect($this->generateUrl($entity->getType() . '_' . $act,array('id'=>$entity->getId())));
	}
	
	/**
	 * Imprime les intervs de la prochaine journée
	 *
	 * @Secure(roles="ROLE_OFFICE")
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
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function printtomorrowAction()
	{
		$now = new \DateTime;
		$em = $this->getDoctrine()->getManager();
		
		do {
			$tomorrow = \DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000');
			$results = $em->getRepository('JLMDailyBundle:Standby')->getCountByDate($tomorrow);
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
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function printdoorAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$door = $em->getRepository('JLMModelBundle:Door')->find($id);
		$shifts = array();
		foreach ($door->getInterventions() as $interv)
		{
			foreach($interv->getShiftTechnicians() as $shift)
			{
				$shifts[(string)$shift->getBegin()->getTimestamp()] = $shift;
			}
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
	
	/**
	 * Export CSV intervs porte
	 *
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function doorcsvAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$door = $em->getRepository('JLMModelBundle:Door')->find($id);
		$shifts = array();
		foreach ($door->getInterventions() as $interv)
		{
			foreach($interv->getShiftTechnicians() as $shift)
			{
				$shifts[(string)$shift->getBegin()->getTimestamp()] = $shift;
			}
		}
		krsort($shifts);
		$response = new Response();
		$response->headers->set('Content-Type', 'text/csv; charset=utf-8');
		$response->headers->set('Content-Disposition', 'inline; filename='.$door->getId().'.csv');
		$response->setContent($this->render('JLMDailyBundle:Intervention:door.csv.twig',array(
						'entity' => $door,
				)));

		return $response;
	}
	
	/**
	 * Export CSV intervs porte
	 *
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function doorxlsAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$door = $em->getRepository('JLMModelBundle:Door')->find($id);
		
		$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
		
		$phpExcelObject->getProperties()->setCreator("JLM Entreprise")
			->setLastModifiedBy("JLM Entreprise")
			->setTitle("Rapport d'intrevention");
//			->setSubject("Office 2005 XLSX Test Document")
//			->setDescription("")
		$as = $phpExcelObject->setActiveSheetIndex(0);
		$titles = array('A'=>'Type','B'=>'Date','C'=>'Raison','D'=>'Constat','E'=>'Action menée','F'=>'Techniciens');
		foreach($titles as $col => $value)
		{
			$as->setCellValue($col.'1', $value);
		}
		$intervs = $door->getInterventions();
		$row = 2;
		foreach ($intervs as $interv)
		{
			if (!$interv->isCanceled() && $interv->getFirstDate())
			{
				
				$date = ($interv->getFirstDate() != $interv->getLastDate())
					? 'du '.$interv->getFirstDate()->format('d/m/Y').chr(10).' au '.$interv->getLastDate()->format('d/m/Y')
					: $interv->getFirstDate()->format('d/m/Y');
				$reason = '';
				if ($interv->getType() == 'work')
				{
					if ($interv->getQuote())
					{
						$reason = 'Selon devis n°'.$interv->getQuote()->getNumber().chr(10);
					}
				}
				$reason .= $interv->getReason();
				$constat = ($interv->getType() == 'fixing') ? $interv->getObservation() : '';
				$report = $interv->getReport();
				$techs = array();
				foreach ($interv->getShiftTechnicians() as $shift)
				{
					$tech = $shift->getTechnician().' ('.$shift->getBegin()->format('d/m/Y');
					if ($shift->getEnd())
					{
						$tech .= ' - '.$shift->getTime()->format('%hh%I');
					}
					$tech .= ')';
					$techs[] = $tech;
				}
				
				$as->setCellValue('A'.$row, $this->get('translator')->trans($interv->getType()))
				   ->setCellValue('B'.$row, $date)
				   ->setCellValue('C'.$row, $reason)
				   ->setCellValue('D'.$row, $constat)
				   ->setCellValue('E'.$row, $report)
				   ->setCellValue('F'.$row, implode(chr(10),$techs));
				$row++;
			}
		}
		
		$phpExcelObject->getActiveSheet()->setTitle('Rapport');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$phpExcelObject->setActiveSheetIndex(0);
		
		// create the writer
		$writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
		// create the response
		$response = $this->get('phpexcel')->createStreamedResponse($writer);
		// adding headers
		$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
		$response->headers->set('Content-Disposition', 'attachment;filename='.$door->getId().'.xls');
		$response->headers->set('Pragma', 'public');
		$response->headers->set('Cache-Control', 'maxage=1');
		
		return $response;
	}
	
	public function publishAction(Request $request, Intervention $entity)
	{
		$entity->setPublished(true);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		
		return $this->redirect($request->headers->get('referer'));
	}
	
	public function unpublishAction(Request $request, Intervention $entity)
	{
		$entity->setPublished(false);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		
		return $this->redirect($request->headers->get('referer'));
	}
}
