<?php

namespace JLM\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
    	phpinfo();
    	exit;
    	$request = $this->getRequest();
    //	$request->setLocale('en_US');

        return array('var'=>$request->getLocale());
	}
}
