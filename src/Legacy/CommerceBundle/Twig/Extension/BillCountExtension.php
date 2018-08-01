<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillCountExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    private $om;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function getName()
    {
        return 'billcount_extension';
    }
    
    public function getGlobals()
    {
        $repo = $this->om->getRepository('JLMCommerceBundle:Bill');
        
        return array('billcount' => array(
            'todo' => $this->om->getRepository('JLMDailyBundle:Intervention')->getCountToBilled(),
            'all' => $repo->getTotal(),
            'input' => $repo->getCount(0),
            'send' => $repo->getCount(1),
            'payed' => $repo->getCount(2),
            'canceled' => $repo->getCount(-1),
        ));
    }
}
