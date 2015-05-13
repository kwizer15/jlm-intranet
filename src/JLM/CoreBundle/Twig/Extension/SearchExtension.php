<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Twig\Extension;

use Symfony\Component\Form\FormFactoryInterface;
use JLM\CoreBundle\Form\Type\SearchType;
use Symfony\Component\DependencyInjection\Container;
use JLM\CoreBundle\Entity\Search;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SearchExtension extends \Twig_Extension
{
	private $formFactory;
//	private $request;
	
	public function __construct(Container $container)
	{
		$this->formFactory = $container->get('form.factory');
//		$this->request = $container->get('request');
	}
	
    public function getName()
    {
        return 'search_extension';
    }
    
    public function getGlobals()
    {
    	$form = $this->formFactory->create('jlm_core_search');
//    	$query = $this->request->get('jlm_core_search');
//    	if (is_array($query) && array_key_exists('query', $query))
//    	{
//    		$form->get('query')->setData($query['query']);
//    	}
//    	
        return array('search' => array(
        	'form' => $form->createView()
        	),
        );
    }
}
