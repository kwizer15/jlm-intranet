<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/search",name="transmitter_search")
     * @Template()
     */
    public function searchAction()
    {
        return array();
    }
}
