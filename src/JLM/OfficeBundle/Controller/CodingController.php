<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\OfficeBundle\Entity\Coding;
use JLM\OfficeBundle\Form\Type\CodingType;
use JLM\OfficeBundle\Entity\CodingLine;



/**
 * Coding controller.
 *
 * @Route("/coding")
 */
class CodingController extends Controller
{
    /**
     * Lists all Quote entities.
     *
     * @Route("/", name="coding")
     * @Route("/page/{page}", name="coding_page")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1)
    {
    	$limit = 10;
        $em = $this->getDoctrine()->getEntityManager();
           
        $nb = $em->getRepository('JLMOfficeBundle:Coding')->getTotal();
        $nbPages = ceil($nb/$limit);
        if ($nbPages < 1)
        	$nbPages = 1;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }
        
        $entities = $em->getRepository('JLMOfficeBundle:Coding')->findBy(
        		array(),
        		array('creation'=>'desc'),
        		$limit,
        		$offset
        );
        
        return array(
        		'entities' => $entities,
        		'page'     => $page,
        		'nbPages'  => $nbPages,
        );
    }

    /**
     * Finds and displays a Quote entity.
     *
     * @Route("/{id}/show", name="coding_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Coding $entity)
    {
        return array('entity'=> $entity);
    }
    
    /**
     * Displays a form to create a new Quote entity.
     *
     * @Route("/new", name="coding_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new Coding();
        $entity->setCreation(new \DateTime);
        $entity->setDiscount(0);
        $entity->addLine(new CodingLine);
        $em = $this->getDoctrine()->getEntityManager();
        $vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
		$entity->setVat($vat);
		$entity->setVatTransmitter($vat);
        $form   = $this->createForm(new CodingType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Coding entity.
     *
     * @Route("/create", name="coding_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Coding:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Coding();
        $form    = $this->createForm(new CodingType(), $entity);
        $form->bind($request);
		
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            $number = $entity->getCreation()->format('ym');
            $em->persist($entity);
            foreach ($entity->getLines() as $key => $line)
            {
            	$line->setCoding($entity);
            	$em->persist($line);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('coding_show', array('id' => $entity->getId())));  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     * @Route("/{id}/edit", name="coding_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Coding $entity)
    {
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->isValid())
    		return $this->redirect($this->generateUrl('coding_show', array('id' => $entity->getId())));
        $editForm = $this->createForm(new CodingType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Coding entity.
     *
     * @Route("/{id}/update", name="coding_update")
     * @Method("post")
     * @Template("JLMOfficeBundle:Coding:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Coding $entity)
    {
    	
    	// Si le devis est déjà validé, on empèche quelconque odification
    	if ($entity->isValid())
    		return $this->redirect($this->generateUrl('coding_show', array('id' => $entity->getId())));
    	 
        $originalLines = array();
        foreach ($entity->getLines() as $line)
        	$originalLines[] = $line;
        $editForm = $this->createForm(new CodingType(), $entity);
        $editForm->bind($request);
        
        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getEntityManager();
        	$em->persist($entity);
        	foreach ($entity->getLines() as $key => $line)
        	{	
      
        		// Nouvelles lignes
        		$line->setCoding($entity);
        		$em->persist($line);
        		
        		// On vire les anciennes
        		foreach ($originalLines as $key => $toDel) 
        			if ($toDel->getId() === $line->getId()) 
        				unset($originalLines[$key]);
        	}
        	foreach ($originalLines as $line)
        	{
        		$em->remove($line);
        	}
            $em->flush();
            return $this->redirect($this->generateUrl('coding_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

   

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
   /**
    * @Route("/{id}/pdf",name="coding_pdf")
    * @Secure(roles="ROLE_USER")
     */
   public function pdfAction(Coding $entity)
   {	
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
        $response->setContent($this->render('JLMOfficeBundle:Coding:older.pdf.php',array('entity'=>$entity)));
     
        return $response;
   }
}
