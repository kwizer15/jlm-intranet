<?php

namespace JLM\CollectiveHousingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('JLMCollectiveHousingBundle:Default:index.html.twig', array('name' => $name));
    }
}
