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
    	$pdf = new \FPDI();
   // 	var_dump($pdf); exit;
    	$pageCount = $pdf->setSourceFile($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/pdf/test.pdf');
    	$onlyPage = $pdf->importPage(1, '/MediaBox');
    //	$firstPage = $pdf->importPage(2, '/MediaBox');
    //	$middlePage = $pdf->importPage(3, '/MediaBox');
    //	$endPage = $pdf->importPage(4 '/MediaBox');
    	
    	// Premiere page
    	$pdf->addPage();
    	$pdf->useTemplate($onlyPage);
    	
    	$pdf->setFont('Arial','B',16);
    	$pdf->cell(40,10,'Hello World !');
    	$content = $pdf->Output('','S');
    	
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename=essai.pdf');
    	$response->setContent($content);
    	
    	return $response;
    }
}
