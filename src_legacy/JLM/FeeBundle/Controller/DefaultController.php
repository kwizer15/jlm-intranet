<?php

namespace JLM\FeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\FeeBundle\Entity\FeesFollower;
use JLM\FeeBundle\Entity\Fee;

/**
 * Contract controller.
 *
 * @Route("/feedefault")
 */
class DefaultController extends Controller
{

    /**
     * Action temporaire
     *
     * Création à la volée des redevances
     *
     * Route("/autocreate")
     * @Template()
     * @deprecated
     */
    public function autocreatefeeAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $contracts = $em->getRepository('JLMContractBundle:Contract')->findAll();
        
        foreach ($contracts as $contract) {
            if ($contract->getInProgress()) {
                $fee = new Fee();
                $fee->addContract($contract);
                $fee->setTrustee($contract->getTrustee());
                $fee->setAddress($contract->getDoor()->getSite()->getAddress()->toString());
                $fee->setPrelabel($contract->getDoor()->getSite()->getBillingPrelabel());
                $fee->setVat($contract->getDoor()->getSite()->getVat());
                $em->persist($fee);
            }
        }
        $em->flush();
        return [];
    }
}
