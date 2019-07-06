<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Entity\Shifting;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\DailyBundle\Form\Type\InterventionCancelType;
use JLM\DailyBundle\JLMDailyEvents;
use JLM\DailyBundle\Event\InterventionEvent;
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
	 * @Security(roles="ROLE_OFFICE")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em
            ->getRepository('JLMDailyBundle:Intervention')
            ->getPrioritary()
        ;

		return array(
				'entities'      => $entities,
		);
	}

	/**
	 * Bill intervention
	 */
	public function tobillAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity->setMustBeBilled(true);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();

		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}

	/**
	 * Don't Bill intervention
	 */
	public function dontbillAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity->setMustBeBilled(false);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();

		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}

	/**
	 * Cancel Bill action
	 */
	public function cancelbillAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function toquoteAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function cancelquoteAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function tocontactAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity->setContactCustomer(false);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();

		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}

	/**
	 * Supprime une demande de devis
	 */
	public function cancelcontactAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity->setContactCustomer(null);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();

		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}

	/**
	 * Créer un ligne travaux
	 */
	public function toworkAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$this->get('event_dispatcher')->dispatch(JLMDailyEvents::INTERVENTION_SCHEDULEWORK, new InterventionEvent($entity));

		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}

	/**
	 * Supprime une ligne travaux
	 */
	public function cancelworkAction(Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$this->get('event_dispatcher')->dispatch(JLMDailyEvents::INTERVENTION_UNSCHEDULEWORK, new InterventionEvent($entity));

		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}

	/**
	 * Annule l'intervention
	 */
	public function cancelAction(Request $request, Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function uncancelAction(Request $request, Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity->uncancel();
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();

		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}

	/**
	 * Numéro de facture
	 */
	public function externalbillAction(Request $request, Intervention $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function todayAction()
	{
	    $this->denyAccessUnlessGranted('ROLE_OFFICE');

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

		return $this->render('JLMDailyBundle:Intervention:today.html.twig', array(
				'inprogress' => $inprogress,
				'fixing' => $em->getRepository('JLMDailyBundle:Fixing')->getToGive(),
				'equipment' => $em->getRepository('JLMDailyBundle:Equipment')->getToday(),
				'notclosed' => $notclosed,
				'closed' => $closed,
				'ago' => $ago,
		));
	}

	/**
	 * Liste des interventions par date(s)
	 *
	 * @Template()
	 */
	public function reportAction($date1 = null,$date2 = null)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function reportdateAction(Request $request)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$date = \DateTime::createFromFormat('d/m/Y',$request->get('datepicker'));

		return $this->redirect($this->generateUrl('intervention_listdate1',array('date1'=>$date->format('Ymd'))));
	}


	/**
	 * Supprimer une intervention
	 *
	 * @Template()
	 */
	public function deleteAction(Shifting $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function redirectAction(Intervention $entity, $act)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		if (!in_array($act,array('show','edit','close')))
		{
			throw $this->createNotFoundException('Page inexistante');
		}

		return $this->redirect($this->generateUrl($entity->getType() . '_' . $act,array('id'=>$entity->getId())));
	}

	/**
	 * Imprime les intervs de la prochaine journée
	 */
	public function printdayAction($date1)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function printtomorrowAction()
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function printdoorAction($id)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function doorcsvAction($id)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
	 */
	public function doorxlsAction($id)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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

	/**
	 * Export CSV intervs porte
	 */
	public function doorsxlsAction()
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$em = $this->getDoctrine()->getManager();
		$page = $this->getRequest()->get('page', 1);
		$limit = $this->getRequest()->get('limit', 500);
		$intervs = $em->getRepository('JLMDailyBundle:Intervention')->findBy(array(), array('id'=>'ASC'), $limit, ($page - 1) * $limit );


		$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

		$phpExcelObject->getProperties()->setCreator("JLM Entreprise")
			->setLastModifiedBy("JLM Entreprise")
			->setTitle("Rapport d'intrevention");
	//			->setSubject("Office 2005 XLSX Test Document")
	//			->setDescription("")
		$as = $phpExcelObject->setActiveSheetIndex(0);

		$titles = array(
			'A' => 'date',
			'B' => 'code installation',
			'C' => 'rue',
			'D' => 'cp',
			'E' => 'ville',
			'F' => 'type contrat',
			'G' => 'interlocuteur',
			'H' => 'tel interlocuteur',
			'I' => 'demande',
			'J' => 'type',
			'K' => 'raison',
			'L' => 'action menée',
			'M' => 'type de\'install',
			'N' => 'constat',
			'O' => 'action menée',
			'P' => 'reste a faire',
			'Q' => 'n° bon d\'intervention',
			'R' => 'devis',
			'S' => 'facture',
			'T' => 'technicien(s)'
		);
		foreach($titles as $col => $value)
		{
			$as->setCellValue($col.'1', $value);
		}
		$row = 2;
		foreach ($intervs as $interv)
		{
			if (!$interv->isCanceled() && $interv->getFirstDate() && $interv->getClosed())
			{
				// A
				$date = ($interv->getFirstDate() != $interv->getLastDate())
					? 'du '.$interv->getFirstDate()->format('d/m/Y').chr(10).' au '.$interv->getLastDate()->format('d/m/Y')
					: $interv->getFirstDate()->format('d/m/Y');
				$as->setCellValue('A'.$row, $date);

				// B
				$door = $interv->getDoor();
				$code = ($door) ? $door->getCode() : '';
				$as->setCellValue('B'.$row, $code);

				// C
				$street = $door ? $door->getAddress()->getStreet() : $interv->getPlace();
					//  faire un regexp sur place pour sortir zip et ville
				$as->setCellValue('C'.$row, $street);

				// D
				$cp = $door ? $door->getAddress()->getCity()->getZip() : '';
				$as->setCellValue('D'.$row, $cp);

				// E
				$city = $door ? $door->getAddress()->getCity()->getName() : '';
				$as->setCellValue('E'.$row, $city);

				// F
				$contrat = $interv->getDynCOntract();
				$as->setCellValue('F'.$row, $contrat);

				// G
				$contact = $interv->getContactName();
				$as->setCellValue('G'.$row, $contact);

				// H
				$contactTel = $interv->getContactPhones();
				$as->setCellValue('H'.$row, $contactTel);

				// I
				$reason = '';
				if ($interv->getType() == 'work')
				{
					if ($interv->getQuote())
					{
						$reason = 'Selon devis n°'.$interv->getQuote()->getNumber().chr(10);
					}
				}
				$reason .= $interv->getReason();
				$as->setCellValue('I'.$row, $reason);

				// J
				$as->setCellValue('J'.$row, $this->get('translator')->trans($interv->getType()));

				// K
				$due = ($interv->getType() == 'fixing') ? $interv->getDue() : '';
				$as->setCellValue('K'.$row, $due);

				// L
				$done = ($interv->getType() == 'fixing') ? $interv->getDone() : '';
				$as->setCellValue('L'.$row, $done);

				// M
				$installtype = $door->getType();
				$as->setCellValue('M'.$row, $installtype);

				// N
				$constat = ($interv->getType() == 'fixing') ? $interv->getObservation() : '';
				$as->setCellValue('N'.$row, $constat);

				// O
				$report = $interv->getReport();
				$as->setCellValue('O'.$row, $report);

				// P
				$rest = $interv->getRest();
				$as->setCellValue('P'.$row, $rest);

				// Q
				$voucher = $interv->getVoucher();
				$as->setCellValue('Q'.$row, $voucher);

				// R
				// S
				$bill = $interv->getBill();
				$bill = $bill === null ? $interv->getExternalBill() : $bill->getNumber();
				$as->setCellValue('S'.$row, $bill);

				// T
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
				$as->setCellValue('T'.$row, implode(chr(10),$techs));

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
		$response->headers->set('Content-Disposition', 'attachment;filename=export_interventions.xls');
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
