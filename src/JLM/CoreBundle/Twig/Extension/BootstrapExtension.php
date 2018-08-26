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
        return [
                new \Twig_SimpleFilter('icon', [$this, 'iconFilter'], ['is_safe' => ['all']]),
                new \Twig_SimpleFilter('badge', [$this, 'badgeFilter'], ['is_safe' => ['all']]),
        ];
    }
    
    public function iconFilter($iconName, $white = false, $version = '2.3.2')
    {
        $v = explode('.', $version);
        if ($v[0] == 2) {
            $return = '<i class="';
            if ($white) {
                $return .= 'icon-white ';
            }
            $return .= 'icon-'.$iconName.'"></i>';
            
            return $return;
        }
        if ($v[0] == 3) {
            return '<span class="glyphicon glyphicon-'.$iconName.'"></span>';
        }
    }
    
    public function badgeFilter($content, $class = null)
    {
        $class = ($class === null) ? 'badge' : 'badge badge-'.$class;
        
        return '<span class="'.$class.'">'.$content.'</span>';
    }
}
