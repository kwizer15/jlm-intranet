<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use JLM\CoreBundle\Entity\Search;

class DefaultController extends Controller
{
    /**
     * @Route(path="/search",name="transmitter_search", methods={"GET"})
     *
     * @Template()
     */
    public function searchAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $formData = $request->get('jlm_core_search');
         
        if (is_array($formData) && array_key_exists('query', $formData)) {
            $em = $this->getDoctrine()->getManager();
            $entity = new Search();
            $query = $formData['query'];
            $entity->setQuery($query);
            return [
                    'transmitters' => $em->getRepository('JLMTransmitterBundle:Transmitter')->search($entity),
            //      'attributions' => $em->getRepository('JLMTransmitterBundle:Attribution')->search($entity),
                    'asks'         => $em->getRepository('JLMTransmitterBundle:Ask')->search($entity),
                   ];
        }
        return [];
    }
}
