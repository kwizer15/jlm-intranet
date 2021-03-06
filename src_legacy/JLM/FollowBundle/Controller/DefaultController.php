<?php

namespace JLM\FollowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contract controller.
 */
class DefaultController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $manager = $this->container->get('jlm_core.mail_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        
        return $manager->paginator(
            'JLMFollowBundle:Thread',
            $request,
            ['entry_type' => null, 'sort' => '!date', 'state' => null]
        );
    }
    
    public function updateAction()
    {
        $om = $this->getDoctrine()->getManager();
        $threads = $this->getDoctrine()->getManager()->getRepository('JLMFollowBundle:Thread')->findAll();
        foreach ($threads as $thread) {
            $thread->getState();
            $thread->getAmount();
            $om->persist($thread);
        }
        
        $om->flush();
        
        return 'Mise à jour OK';
    }
}
