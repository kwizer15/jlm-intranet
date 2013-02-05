<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



/**
 * Order controller.
 *
 * @Route("/order")
 */
class OrderController extends Controller
{
	/**
	 * Lists all Order entities.
	 *
	 * @Route("/", name="order")
	 * @Route("/page/{page}", name="order_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction($page = 1)
	{
	}
}