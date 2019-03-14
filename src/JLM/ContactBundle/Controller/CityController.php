<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CityController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * City json
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function searchAction(Request $request)
    {
        $manager = $this->container->get('jlm_contact.city_manager');
        $term = $request->get('q');
        $page_limit = $request->get('page_limit');
        $cities = $manager->getRepository()->getArray($term, $page_limit);

        return $manager->renderJson(['cities' => $cities]);
    }

    /**
     * City json
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function jsonAction(Request $request)
    {
        $manager = $this->container->get('jlm_contact.city_manager');
        $id = $request->get('id');
        $city = $manager->getRepository()->getByIdToArray($id);

        return $manager->renderJson($city);
    }
}
