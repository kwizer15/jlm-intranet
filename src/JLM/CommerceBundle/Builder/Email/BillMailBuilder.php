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
use JLM\CommerceBundle\Model\BillInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class BillMailBuilder extends MailBuilderAbstract
{
    /**
     * @var BillInterface
     */
    private $bill;
    
    /**
     * @param BillInterface $bill
     */
    public function __construct(BillInterface $bill)
    {
        $this->bill = $bill;
    }

    /**
     * @return BillInterface
     */
    public function getBill()
    {
        return $this->bill;
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
        $boostContacts = $this->getBill()->getBoostContacts();
        foreach ($boostContacts as $contact) {
            $this->addTo($contact->getEmail(), $contact->getName());
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCc()
    {
        $managerContacts = $this->getBill()->getManagerContacts();
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
