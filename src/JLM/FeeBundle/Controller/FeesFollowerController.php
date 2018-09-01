<?php

namespace JLM\FeeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\FeeBundle\Entity\Fee;
use JLM\FeeBundle\Entity\FeesFollower;
use JLM\CommerceBundle\Entity\Bill;
use JLM\CommerceBundle\Entity\BillLine;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JLM\CommerceBundle\Factory\BillFactory;
use JLM\FeeBundle\Builder\FeeBillBuilder;
use JLM\FeeBundle\Form\Type\FeesFollowerType;

/**
 * Fees controller.
 *
 * @Route("/fees")
 */
class FeesFollowerController extends Controller
{
    /**
     * Lists all Fees entities.
     *
     * @Route("/", name="fees")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMFeeBundle:FeesFollower')->findBy(
            [],
            ['activation' => 'desc']
        )
        ;

        return ['entities' => $entities];
    }

    /**
     * Edit a FeesFollower entities.
     *
     * @Route("/{id}/edit", name="fees_edit")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function editAction(FeesFollower $entity)
    {
        $editForm = $this->createForm(new FeesFollowerType(), $entity);

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ];
    }

    /**
     * Edits an existing FeesFollower entity.
     *
     * @Route("/{id}/update", name="fees_update")
     * @Method("post")
     * @Template("JLMOfficeBundle:Fees:edit.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function updateAction(Request $request, FeesFollower $entity)
    {
        $editForm = $this->createForm(new FeesFollowerType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fees', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ];
    }

    /**
     * Edits an existing FeesFollower entity.
     *
     * @Route("/{id}/generate", name="fees_generate")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function generateAction(FeesFollower $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $fees = $em->getRepository('JLMFeeBundle:Fee')
            ->createQueryBuilder('a')
            ->select('a')
            ->leftJoin('a.contracts', 'b')
            ->leftJoin('b.door', 'c')
            ->leftJoin('c.site', 'd')
            ->leftJoin('d.address', 'e')
            ->leftJoin('e.city', 'f')
            //          ->where('b.end is null OR b.end > ?1')
            //          ->andWhere('b.begin <= ?1')
            //
            //          ->setParameter(1, $entity->getActivation())
            ->orderBy('f.name', 'asc')
            ->getQuery()
            ->getResult()
        ;

        $number = null;
        // @todo Ajouter pas de facture si sous garantie
        foreach ($fees as $fee) {
            $contracts = $fee->getActiveContracts($entity->getActivation());
            if (count($contracts)) {
                $gf = 'getFrequence' . $fee->getFrequence();
                if ($entity->$gf() !== null) {
                    // On fait l'augmentation dans le contrat
                    $majoration = $entity->$gf();
                    if ($majoration > 0) {
                        foreach ($contracts as $contract) {
                            $amount = $contract->getFee();
                            $amount *= (1 + $majoration);
                            $contract->setFee($amount);
                            $em->persist($contract);
                        }
                    }
                    $builder = new FeeBillBuilder(
                        $fee,
                        $entity,
                        [
                            'number' => $number,
                            'product' => $em->getRepository('JLMProductBundle:Product')->find(284),
                            'penalty' => (string) $em->getRepository('JLMCommerceBundle:PenaltyModel')->find(1),
                            'earlyPayment' => (string) $em->getRepository('JLMCommerceBundle:EarlyPaymentModel')
                                ->find(
                                    1
                                ),
                            'vatTransmitter' => $em->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate(),
                        ]
                    );
                    $bill = BillFactory::create($builder);
                    if ($bill->getTotalPrice() > 0) {
                        $em->persist($bill);
                        $number = $bill->getNumber() + 1;
                    }
                }
            }
        }

        $entity->setGeneration(new \DateTime());
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('fees', ['id' => $entity->getId()]));
    }

    /**
     * Print bills
     * @Route("/{id}/print", name="fees_print")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function printAction(FeesFollower $follower)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMCommerceBundle:Bill')->getFees($follower);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set(
            'Content-Disposition',
            'inline; filename=redevances-' . $follower->getActivation()->format('m-Y') . '.pdf'
        );
        $response->setContent(
            $this->render('JLMCommerceBundle:Bill:print.pdf.php', ['entities' => $entities, 'duplicate' => false])
        );

        return $response;
    }
}
