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
use Symfony\Component\Translation\TranslatorInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillCountExtension extends \Twig_Extension
{
    private $om;
    private $translator;
    
    public function __construct(ObjectManager $om, TranslatorInterface $translator)
    {
        $this->om = $om;
        $this->translator = $translator;
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
    
    public function getFilters()
    {
    	return array(
    			new \Twig_SimpleFilter('bill_state_label', array($this, 'stateLabelFilter'), array('is_safe' => array('html'))),
    			new \Twig_SimpleFilter('bill_state_header', array($this, 'stateHeaderFilter'), array('is_safe' => array('html'))),
    	);
    }
    
    private function getStateLabelClass($state)
    {
    	switch ($state)
    	{
    		case 0:
    			$class = 'default';
    			break;
    		case 1:
    			$class = 'primary';
    			break;
    		case 2:
    			$class = 'success';
    			break;
    		default:
    			$class = 'danger';
    	}
    	
    	return $class;
    }
    
    private function getStateHeaderClass($state)
    {
    	switch ($state)
    	{
    		case 0:
    			$class = 'warning';
    			break;
    		case 1:
    			$class = 'info';
    			break;
    		case 2:
    			$class = 'success';
    			break;
    		default:
    			$class = 'danger';
    	}
    	 
    	return $class;
    }
    
    private function getStateMessage($state)
    {
    	switch ($state)
    	{
    		case 0:
    			$message = 'in_seizure';
    			break;
    		case 1:
    			$message = 'sended';
    			break;
    		case 2:
    			$message = 'payed';
    			break;
    		default:
    			$message = 'canceled';
    	}
    	 
    	return $message;
    }
    
    public function stateLabelFilter($quote)
    {
    	$state = $quote->getState();
    	$class = $this->getStateLabelClass($state);
    	$message = $this->getStateMessage($state);
    	
    	return '<span class="label label-'.$class.'">'.$this->translator->trans($message,array(),'BillStates').'</span>';
    }
    
    public function stateHeaderFilter($quote)
    {
    	$state = $quote->getState();
    	$class = $this->getStateHeaderClass($state);
    	$message = $this->getStateMessage($state);
    	
    	return '<div class="alert alert-'.$class.'"><h4>'.$this->translator->trans($message,array(),'BillStates').'</h4></div>';
    }
}
