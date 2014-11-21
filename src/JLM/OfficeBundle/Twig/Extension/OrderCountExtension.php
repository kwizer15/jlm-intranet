<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class OrderCountExtension extends \Twig_Extension
{
    private $om;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function getName()
    {
        return 'ordercount_extension';
    }
    
    public function getGlobals()
    {
        $repo = $this->om->getRepository('JLMOfficeBundle:Order');
        
        return array('ordercount' => array(
				'todo' => $this->om->getRepository('JLMDailyBundle:Work')->getCountOrderTodo(),
				'all' => $repo->getTotal(),
				'input' => $repo->getCount(0),
				'ordered' => $repo->getCount(1),
				'ready' => $repo->getCount(2),
		));
    }
}
