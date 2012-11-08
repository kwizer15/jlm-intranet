<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Address;
use JLM\ModelBundle\Form\AddressType;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_ADMIN")
     */
    public function indexAction()
    {
        return array('name'=>'Bonjour');
    }
    
    /**
     * @Route("/testpdf")
     */
    public function testpdfAction()
    {
    	$pdf = new \FPDF();
    	$pdf->AddPage();
    	$pdf->SetFont('Arial','B',16);
    	$pdf->Cell(40,10,'Hello World !');
    	$content = $pdf->Output('','S');
    	
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename=essai.pdf');
    	$response->setContent($content);
    	
    	return $response;
    }
}
