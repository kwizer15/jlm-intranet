<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\NoResultException;
use JLM\DailyBundle\Entity\Maintenance;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Entity\Site;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BusinessController extends Controller
{

    public function tabAction()
    {
    }

    public function listAction(Request $request)
    {
        $om = $this->get('doctrine')->getManager();
        $manager = $this->getConnectedManager($request);
        $repoSite = $om->getRepository('JLMModelBundle:Site');
        if ($manager instanceof Trustee) {
            $sites = $repoSite->getByManager($manager);
            $activeBusinessId = sizeof($sites) ? $request->get('business', reset($sites)->getId()) : null;
            try {
                $activeBusiness = $repoSite->find($activeBusinessId);
                if (!$activeBusiness->hasContractWith($manager)) {
                    $activeBusinessId = sizeof($sites) ? reset($sites)->getId() : null;
                    $activeBusiness = $repoSite->find($activeBusinessId);
                }
                // Vérifier si l'affaire fait partie du syndic
            } catch (\Doctrine\ORM\NoResultException $e) {
                throw $this->createNotFoundException('Cette affaire n\'existe pas');
            }
        }
        if ($manager instanceof Site) {
            $activeBusiness = $manager;
            $sites = [$activeBusiness];
            $manager = $activeBusiness->getTrustee();
        }

        // Filtre pour les contrats actuels
        $doors = $activeBusiness->getDoors();
        $businessDoors = [];
        $lastsMaintenance = [];
        $lastsFixing = [];
        $askQuoteForms = [];
        $qs = [];
        foreach ($doors as $key => $door) {
            $contract = $door->getActualContract();
            if ($contract !== null && $contract->getTrustee() == $manager) {
                $businessDoors[$key] = $door;
                $lastsMaintenance[$key] = $om->getRepository('JLMDailyBundle:Maintenance')->getLastsByDoor($door, 2);
                $lastsFixing[$key] = $om->getRepository('JLMDailyBundle:Intervention')->getLastsByDoor($door, 5, true);
                usort(
                    $lastsFixing[$key],
                    function ($a, $b) {
                        return ($a->getLastDate() < $b->getLastDate()) ? 1
                            : (($a->getLastDate() == $b->getLastDate()) ? 0 : -1);
                    }
                );
                $lastsFixing[$key] = array_filter(
                    $lastsFixing[$key],
                    function ($item) {
                        return !$item instanceof Maintenance;
                    }
                );
                $qs[$key] = $om->getRepository('JLMCommerceBundle:Quote')->getSendedByDoor($door, 12);
                $askQuoteForms[$key] = [];
                foreach ($qs[$key] as $quote) {
                    $form = $this->createAskQuoteForm();
                    $form->get('quoteNumber')->setData($quote->getNumber());
                    $askQuoteForms[$key][] = $form->createView();
                }
            }
        }

        return $this->render(
            '@JLMFront/business/list.html.twig',
            [
                'manager' => $manager,
                'businesses' => $sites,
                'activeBusiness' => $activeBusiness,
                'doors' => $businessDoors,
                'lastsMaintenance' => $lastsMaintenance,
                'lastsFixing' => $lastsFixing,
                'quotes' => $qs,
                'askQuoteForms' => $askQuoteForms,
            ]
        );
    }

    public function askquoteAction(Request $request)
    {
        $form = $this->createAskQuoteForm();
        $form->handleRequest($request);

        if ($success = $form->isValid()) {
            $this->container->get('jlm_front.mailer')->sendAskQuoteEmailMessage($form->getData());
            $this->container->get('jlm_front.mailer')->sendConfirmAskQuoteEmailMessage($form->getData());
        }

        return new JsonResponse(['success' => $success]);
    }

    private function createAskQuoteForm()
    {
        $form = $this->createForm(
            'jlm_front_askquotetype',
            null,
            [
                'action' => $this->generateUrl('jlm_front_business_askquote'),
                'method' => 'POST',
            ]
        );
        $form->add('submit', SubmitType::class);

        return $form;
    }
}
