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
use JLM\CommerceBundle\Model\BusinessInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class BusinessMailBuilder extends MailBuilderAbstract
{
    /**
     * @var BusinessInterface
     */
    private $business;
    
    /**
     * @param BusinessInterface $bill
     */
    public function __construct(BusinessInterface $business)
    {
        $this->business = $business;
    }

    /**
     * @return BusinessInterface
     */
    public function getBusiness()
    {
        return $this->business;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildFrom()
    {
        $this->addFrom('secretariat@jlm-entreprise.fr', 'Secrétariat (JLM Entreprise)');
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildTo()
    {
        $boostContacts = $this->getBusiness()->getBoostContacts();
        foreach ($boostContacts as $contact) {
            $this->addTo($contact->getEmail(), $contact->getName());
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCc()
    {
        $managerContacts = $this->getBusiness()->getManagerContacts();
        foreach ($managerContacts as $contact) {
            $this->addCc($contact->getEmail(), $contact->getName());
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildBcc()
    {
        $this->addBcc('secretariat@jlm-entreprise.fr', 'Secrétariat (JLM Entreprise)');
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildAttachements()
    {
    }
}
