<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContractBundle\Entity\Contract;

/**
 * Quote controller.
 *
 * @Route("/contract")
 */
class ContractController extends Controller
{
    /**
     * @Route("/{id}/print",name="contract_print")
     * @Route("/{id}/print/{number}",name="contract_printnumb")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function printAction(Contract $entity, $number = 0)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=' . $entity->getNumber() . '.pdf');
        $response->setContent(
            $this->render('JLMOfficeBundle:Contract:bill.pdf.php', ['entities' => [$entity], 'number' => $number])
        );

        //   return array('entity'=>$entity);
        return $response;
    }

    /**
     * @Route("/printall",name="contract_printall")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function printallAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMContractBundle:Contract')->findAll();
        $today = new \DateTime();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set(
            'Content-Disposition',
            'inline; filename=redevances-' . $today->format('Y-m-d') . '.pdf'
        );
        $response->setContent($this->render('JLMOfficeBundle:Contract:bill.pdf.php', ['entities' => $entities]));

        //   return array('entity'=>$entity);
        return $response;
    }
}
