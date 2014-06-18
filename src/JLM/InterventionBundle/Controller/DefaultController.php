<?php

namespace JLM\InterventionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JLMInterventionBundle:Default:index.html.twig', array('name' => $name));
    }
}
