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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CityController extends ContainerAware
{
    /**
     * City json
     */
    public function searchAction()
    {
        $manager = $this->container->get('jlm_contact.city_manager');
        $request = $manager->getRequest();
        $term = $request->get('q');
        $page_limit = $request->get('page_limit');
        ;
        $cities = $manager->getRepository()->getArray($term, $page_limit);
        
        return $manager->renderJson(['cities' => $cities]);
    }
    
    /**
     * City json
     */
    public function jsonAction()
    {
        $manager = $this->container->get('jlm_contact.city_manager');
        $id = $manager->getRequest()->get('id');
        $city = $manager->getRepository()->getByIdToArray($id);
        
        return $manager->renderJson($city);
    }
}
