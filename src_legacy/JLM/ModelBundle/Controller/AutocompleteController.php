<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AutocompleteController extends Controller
{
    public function cityAction()
    {
        $request = $this->get('request');
        $query = $request->request->get('term');

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('JLMContactBundle:City')->searchResult($query);
        $json = json_encode($results);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);
        return $response;
    }

    public function trusteeAction()
    {
        $request = $this->get('request');
        $query = $request->request->get('term');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('JLMModelBundle:Trustee')->searchResult($query);
        $json = json_encode($results);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);

        return $response;
    }

    public function siteAction()
    {
        $request = $this->get('request');
        $query = $request->request->get('term');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('JLMModelBundle:Site')->searchResult($query);
        $json = json_encode($results);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);

        return $response;
    }

    public function contractAction()
    {
        $request = $this->get('request');
        $query = $request->request->get('term');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('JLMContractBundle:Contract')->searchResult($query);
        $json = json_encode($results);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);

        return $response;
    }

    public function indexAction(Request $request)
    {
        $query = $request->request->get('term');
        $em = $this->getDoctrine()->getManager();
        $repository = $request->request->get('repository');
        $action = $request->request->get('action');
        $action = empty($action) ? 'Result' : $action;
        $action = 'search' . $action;
        $results = $em->getRepository($repository)->$action($query);
        $json = json_encode($results);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);
        return $response;
    }

    /**
     * @todo Voir si cette action est utile car pas de "Action" dans le nom de la fonction quand j'ai réécrit le
     *       routage en yml
     */
    public function doorsiteAction(Request $request)
    {
        $id = $request->request->get('id_site');
        $em = $this->getDoctrine()->getManager();
        $site = $em->getRepository('JLMModelBundle:Site')->find($id);
        $results = $em->getRepository('JLMModelBundle:Door')->findBy(['site' => $site]);
        $doors = [];
        foreach ($results as $result) {
            $doors[] = [
                'id' => $result->getId(),
                'string' => $result->getType() . ' - ' . $result->getLocation() . ' / ' . $result->getStreet(),
            ];
        }
        $json = json_encode($doors);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);
        return $response;
    }
}
