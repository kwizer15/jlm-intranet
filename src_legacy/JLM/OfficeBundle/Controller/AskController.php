<?php

namespace JLM\OfficeBundle\Controller;

use JLM\DefaultBundle\Controller\PaginableController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ask controller.
 */
abstract class AskController extends PaginableController
{

    public function indexAction($page = 1)
    {
        return $this->pagination($this->getRepositoryName(), 'All', $page, 10);
    }
    
    public function listtreatedAction($page = 1)
    {
        return $this->pagination($this->getRepositoryName(), 'Treated', $page, 10);
    }
    
    public function listuntreatedAction($page = 1)
    {
        return $this->pagination($this->getRepositoryName(), 'Untreated', $page, 10);
    }

    public function canceldonttreatAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $this->getEntity($em, $id);
        $entity->setDontTreat();
        $em->persist($entity);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * @return Repository
     */
    abstract protected function getRepositoryName();
    
    /**
     * @return Entity
     */
    protected function getEntity($em, $id)
    {
        $entity = $em->getRepository($this->getRepositoryName())->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find '.$this->getRepositoryName().' entity.');
        }
        return $entity;
    }
}
