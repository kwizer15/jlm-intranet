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
		$em = $this->getDoctrine()->getManager();
		$entity->setMustBeBilled(true);
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
		$em = $this->getDoctrine()->getManager();
		$entity->setMustBeBilled(false);
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
		$em = $this->getDoctrine()->getManager();
		$ask = new AskQuote;
		$ask->populateFromIntervention($entity);
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
			$em = $this->getDoctrine()->getManager();
			$em->remove($ask);
			$entity->setAskQuote();
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
		$em = $this->getDoctrine()->getManager();
		$entity->setContactCustomer(false);
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
		$em = $this->getDoctrine()->getManager();
		$entity->setContactCustomer(null);
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
		$em = $this->getDoctrine()->getManager();
		$work = $entity->getWork();
		$entity->setWork();
		$em->remove($work);
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
		$f = $em->getRepository('JLMDailyBundle:Fixing')->getToday();
		$w = $em->getRepository('JLMDailyBundle:Work')->getToday();
		$m = $em->getRepository('JLMDailyBundle:Maintenance')->getToday();
		$intervs = array_merge($f,$w,$m);
		unset($f);
		unset($w);
		unset($m);
		
		$inprogress = $notclosed = $closed = array();
		foreach ($intervs as $interv)
		{
			$flag = false;
			if ($interv->getState() == 3 && !$flag)
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
		
		$fixingstogive = $em->getRepository('JLMDailyBundle:Fixing')->getToGive();
		
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getToday();

		return array(
				'inprogress' => $inprogress,
				'fixing' => $fixingstogive,
				'equipment' => $equipment,
				'notclosed' => $notclosed,
				'closed' => $closed,
		);
		
		// ORDRE DES INTERVS
		// - Toutes ayant au moins un intervenant aujourd'hui
		// - Les dépannages sans intervenant
		// - Les travaux non cloturés
		// - Les travaux sans intervenant
		// - Les entretiens sans intervenant
		
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
		$standby = $em->getRepository('JLMDailyBundle:Standby')
			->createQueryBuilder('s')
			->where('s.begin <= ?1 AND s.end >= ?1')
			->setParameter(1,$date1)
			->setMaxResults(1)
			->getQuery()
			->getResult()
		;
		if (empty($standby))
			$standby = null;
		else
			$standby = $standby[0]->getTechnician();
		return array(
				'standby' => $standby,
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
		if ($entity instanceof Intervention)
		{
			if (null !== $entity->getOfficeAction())
				$em->remove($entity->getOfficeAction());
			if (null !== $entity->getOtherAction())
				$em->remove($entity->getOtherAction());
		}	
			
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
		$standby = $em->getRepository('JLMDailyBundle:Standby')
			->createQueryBuilder('s')
			->where('s.begin <= ?1 AND s.end >= ?1')
			->setParameter(1,$date1)
			->setMaxResults(1)
			->getQuery()
			->getResult()
		;
		if (empty($standby))
			$standby = null;
		else
			$standby = $standby[0]->getTechnician();
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$d1->format('Y-m-d').'.pdf');
		$response->setContent($this->render('JLMDailyBundle:Intervention:printday.pdf.php',
				array('date' => $d1,
						'entities' => array_merge($equipment,$intervs),
						'standby' => $standby,
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
			
			$results = $em->getRepository('JLMDailyBundle:Standby')
				->createQueryBuilder('s')
				->select('COUNT(s)')
				->where('s.begin <= ?1')
				->andWhere('s.end >= ?1')
				->setParameter(1,$tomorrow->format('Y-m-d'))
				->getQuery()
				->getSingleScalarResult();
		} while ($results);
		
		$intervs = $em->getRepository('JLMDailyBundle:Intervention')->getWithDate($tomorrow,$tomorrow);
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getWithDate($tomorrow,$tomorrow);
		$fixing = $em->getRepository('JLMDailyBundle:Fixing')->createQueryBuilder('i')
			->leftJoin('i.shiftTechnicians','t')
			->where('t is null')
			->andWhere('i.close is null')
			->orderBy('i.creation','asc')
			->getQuery()
			->getResult();
			;
		
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
//		$entities = $em->getRepository('JLMDailyBundle:ShiftTechnician')
//			->createQueryBuilder('a')
//			->select('a,b,c')
//			->leftJoin('a.shifting','b')
//			->leftJoin('b.door','c')
//			->where('c.id = ?1')
//			->andWhere('b INSTANCE OF JLM\DailyBundle\Entity\Intervention')
//			->orderBy('t.begin','desc')
//			->setParameter(1,$id)
//			->getQuery()
//			->getResult();
//		$i = array();
//		foreach ($intervs as $interv)
//		{
//			$i[] = $interv['id'];
//		}
//
//		$qb = $em->getRepository('JLMDailyBundle:ShiftTechnician')
//			->createQueryBuilder('a');
//		$qb->select('a,b')
//			->leftJoin('a.shifting','b')
//			->add('where',$qb->expr()->in('b.id',$i))
//			->orderBy('a.begin','desc');
//		$shifts = $qb->getQuery()
//			->getResult();
		
//		$intervs = $door->getInterventions();
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
	
	/**
	 * Mise à jour des tâches facturation
	 * (à faire évoluer pour les devis, plannification et contact)
	 *
	 * @Route("/upgradeoffice", name="intervention_upgradeoffice")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function upgradeofficeAction()
	{
		$em = $this->getDoctrine()->getManager();
		$id_bill = 1;
		$id_quote = 2;
		$id_order = 3;
		$id_contact = 4;
		$id_not = 5;
		$work_objective = $em->getRepository('JLMDailyBundle:WorkObjective')->find(1);
		$work_category = $em->getRepository('JLMDailyBundle:WorkCategory')->find(1);
		$intervs = $em->getRepository('JLMDailyBundle:Intervention')->findAll();
		foreach ($intervs as $interv)
		{
			if ($interv->getOfficeAction() !== null)
			{
				$id = $interv->getOfficeAction()->getType()->getId();
				if ($id == $id_bill)
				{
					$interv->setMustBeBilled(true);
					// On ne crée pas la facture pour gérer les non facturé et les numéros plus tard
				}
				elseif ($id == $id_not)
				{
					$interv->setMustBeBilled(false);
				}
				
			}
			if ($interv->getOtherAction() !== null && $interv->getRest() !== null)
			{
				$id = $interv->getOtherAction()->getType()->getId();
				if ($id == $id_quote && $interv->getAskQuote() === null)
				{
					$askQuote = new AskQuote;
					$maturity = clone $interv->getOtherAction()->getOpen();
					$maturity->add(new \DateInterval('P15D'));
					$askQuote->setCreation($interv->getOtherAction()->getOpen());
					$askQuote->setMaturity($maturity);
					$askQuote->setIntervention($interv);
					if ($interv->getRest() === null)
					{
						echo $interv->getId(); exit;
					}
					$askQuote->setAsk($interv->getRest());
					$em->persist($askQuote);
					$interv->setAskQuote($askQuote);
				}
				elseif ($id == $id_order && $interv->getWork() === null)
				{
					$work = new Work;
					$work->setCreation($interv->getClose());
					$work->setPlace($interv->getPlace());
					$work->setReason($interv->getRest());
					$work->setDoor($interv->getDoor());
					$work->setContactName($interv->getContactName());
					$work->setContactPhones($interv->getContactPhones());
					$work->setContactEmail($interv->getContactEmail());
					$work->setPriority(4);
//					$work->setContact($interv->getContact());
					$work->setObjective($work_objective);
					$work->setCategory($work_category);
					$work->setIntervention($interv);
					$em->persist($work);
					$interv->setWork($work);
				}
				elseif ($id == $id_contact)
				{
					$interv->setContactCustomer(false);
				}
			}
			$em->persist($interv);
		}
		
		$em->flush();
		
		return array();
	}
}
