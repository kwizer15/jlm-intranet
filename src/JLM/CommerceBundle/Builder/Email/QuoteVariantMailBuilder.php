<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Builder\Email;

use JLM\CoreBundle\Builder\MailBuilderAbstract;
use JLM\DailyBundle\Model\InterventionInterface;
use JLM\DailyBundle\Model\FixingInterface;
use JLM\CommerceBundle\Entity\QuoteVariant;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class QuoteVariantMailBuilder extends MailBuilderAbstract
{
    private $variant;
    
    public function __construct(QuoteVariant $variant)
    {
        $this->variant = $variant;
    }

    public function getQuoteVariant()
    {
        return $this->variant;
    }
    
    public function buildFrom()
    {
        $this->addFrom('commerce@jlm-entreprise.fr', 'Commerce (JLM Entreprise)');
    }
    
    public function buildTo()
    {
        $managerContacts = $this->getQuoteVariant()->getManagerContacts();
        foreach ($managerContacts as $contact) {
            //$this->addTo($contact);
            $this->addTo($contact->getEmail(), $contact->getName());
        }
    }
    
    public function buildCc()
    {
        $administratorContacts = $this->getQuoteVariant()->getAdministratorContacts();
        foreach ($administratorContacts as $contact) {
            //$this->addCc($contact);
            $this->addCc($contact->getEmail(), $contact->getName());
        }
    }
    
    public function buildBcc()
    {
        $this->addBcc('commerce@jlm-entreprise.fr', 'Commerce (JLM Entreprise)');
    }
    

    public function buildAttachements()
    {
    }
}
