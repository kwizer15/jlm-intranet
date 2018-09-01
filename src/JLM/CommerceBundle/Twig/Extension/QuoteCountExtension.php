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
use JLM\CommerceBundle\Model\QuoteInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteCountExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
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
        return 'quotecount_extension';
    }
    
    public function getGlobals()
    {
        $date = new \DateTime;
        $year = $date->format('Y');
        $repo = $this->om->getRepository('JLMCommerceBundle:Quote');
        
        return [
                'quotecount' => [
                                 'all'   => $repo->getCountState('uncanceled', $year),
                                 'input' => $repo->getCountState(0, $year),
                                 'wait'  => $repo->getCountState(1, $year),
                                 'send'  => $repo->getCountState(3, $year),
                                 'given' => $repo->getCountState(5, $year),
                                ],
                'quotelasts' => $repo->findBy(
                    [],
                    ['number' => 'desc'],
                    5
                ),
               ];
    }
    
    public function getFilters()
    {
        return [
                new \Twig_SimpleFilter('quote_state_label', [$this, 'stateLabelFilter'], ['is_safe' => ['all']]),
               ];
    }
    
    public function stateLabelFilter($quote)
    {
        $class = '';
        $message = '';
        $state = $quote->getState();
        switch ($state) {
            case 0:
                $message = 'in_seizure';
                break;
            case 1:
            case 2:
                $class = 'warning';
                $message = 'waiting';
                break;
            case 3:
            case 4:
                $class = 'info';
                $message = 'sended';
                break;
            case 5:
                $class = 'success';
                $message = 'given';
                break;
            default:
                $class = 'important';
                $message = 'canceled';
        }
        $out = '<span class="label';
        if ($class != '') {
            $out .= ' label-'.$class;
        }
        $out .= '">'.$this->translator->trans($message, [], 'QuoteStates').'</span>';
        
        return $out;
    }
}
