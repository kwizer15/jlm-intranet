<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Twig\Extension;

use Doctrine\Common\Persistence\ObjectManager;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BootstrapExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'bootstrap_extension';
    }
    
    public function getFilters()
    {
        return array(
        		new \Twig_SimpleFilter('icon', array($this, 'iconFilter'), array('is_safe' => array('all'))),
        		new \Twig_SimpleFilter('badge', array($this, 'badgeFilter'), array('is_safe' => array('all'))),
        );
    }
    
    public function iconFilter($iconName, $white = false, $version = '2.3.2')
    {
    	$v = explode('.', $version);
    	if ($v[0] == 2)
    	{
    		$return = '<i class="';
    		if ($white)
    		{
    			$return .= 'icon-white ';
    		} 
    		$return .= 'icon-'.$iconName.'"></i>';
    		
    		return $return;
    	}
    	if ($v[0] == 3)
    	{
    		return '<spab class="glyphicon glyphicon-'.$iconName.'"></i>';
    	}
    }
    
    public function badgeFilter($content, $class = null)
    {
    	$class = ($class === null) ? 'badge' : 'badge badge-'.$class;
    	
    	return '<span class="'.$class.'">'.$content.'</span>';
    }
}
