<?php
namespace JLM\FeeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Fee;
use JLM\OfficeBundle\Entity\FeesFollower;
use JLM\OfficeBundle\Entity\Bill;
use JLM\OfficeBundle\Entity\BillLine;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



/**
 * Fees controller.
 *
 * @Route("/fees")
 */
class FeesController extends Controller
{
	/**
	 * Lists all Fees entities.
	 *
	 * @Route("/", name="fees")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
	
		$entities = $em->getRepository('JLMOfficeBundle:FeesFollower')->findBy(
				array(),
				array('activation'=>'desc')
		);
	
		return array(
				'entities' => $entities,
		);
	}
	
	/**
	 * Edit a FeesFollower entities.
	 *
	 * @Route("/{id}/edit", name="fees_generate")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function editAction(FeesFollower $entity)
	{	
		$editForm = $this->createForm(new FeesFollower(), $entity);
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing FeesFollower entity.
	 *
	 * @Route("/{id}/update", name="fees_update")
	 * @Method("post")
	 * @Template("JLMOfficeBundle:Fees:edit.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function updateAction(Request $request,FeesFollower $entity)
	{
		$editForm = $this->createForm(new FeesFollowerType(), $entity);
		$editForm->bind($request);
	
		if ($editForm->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('fees', array('id' => $entity->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing FeesFollower entity.
	 *
	 * @Route("/{id}/generate", name="fees_generate")
	 * @Secure(roles="ROLE_USER")
	 */
	public function generateAction(FeesFollower $entity)
	{
		$em = $this->getDoctrine()->getManager();
		$today = new \DateTime;
		$vattrans = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
		$product = $em->getRepository('JLMModelBundle:Product')->find(2); // Produit redevance
		foreach (array(1,2,4) as $frequence)
		{
			$gf = 'getFrequence'.$frequence;
			if ($entity->$gf() !== null)
			{
				$fees = $em->getRepository('JLMModelBundle:Fee')->findBy(array('frequence'=>$frequence));	
				foreach ($fees as $fee)
				{
					$bill = $fee->getBill($product,$entity);
					$bill->setVatTransmitter($vattrans);
					$em->persist($bill);
				}
			}
		}
		$em->flush();
		
		return $this->redirect($this->generateUrl('fees', array('id' => $entity->getId())));
	}
}