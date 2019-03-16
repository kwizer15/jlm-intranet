<?php

namespace JLM\AskBundle\Entity;

use JLM\ModelBundle\Entity\UploadDocument;
use JLM\AskBundle\Model\PayerInterface;
use JLM\AskBundle\Model\SubjectInterface;
use JLM\AskBundle\Model\AskInterface;
use JLM\AskBundle\Model\CommunicationMeansInterface;
use JLM\AskBundle\Model\ContactInterface;

abstract class Ask extends UploadDocument implements AskInterface
{
    /**
     * Syndic
     *
     * @var PayerInterface
     */
    private $trustee;
    
    /**
     * Affaire
     *
     * @var SubjectInterface
     */
    private $site;
    
    /**
     * Méthode de la demande
     *
     * @var CommunicationMeansInterface
     */
    private $method;
    
    /**
     * Date de la demande
     *
     * @var \DateTime
     */
    private $creation;
    
    /**
     * Date d'échéance
     *
     * @var \DateTime
     */
    private $maturity;
    
    /**
     * Contact
     *
     * @var ContactInterface
     */
    private $person;

    /**
     * Ne pas traiter
     *
     * @var string
     */
    private $dontTreat;

    /**
     * Résumé de la demande
     *
     * @var string
     */
    private $ask;
    
    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Ask
     */
    public function setCreation($creation): self
    {
        $this->creation = $creation;
    
        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime
     */
    public function getCreation(): \DateTime
    {
        return $this->creation;
    }

    /**
     * Set maturity
     *
     * @param \DateTime $maturity
     *
     * @return Ask
     */
    public function setMaturity($maturity): self
    {
        $this->maturity = $maturity;
    
        return $this;
    }

    /**
     * Get maturity
     *
     * @return \DateTime
     */
    public function getMaturity(): ?\DateTime
    {
        return $this->maturity;
    }

    /**
     * Set trustee
     *
     * @param PayerInterface $trustee
     *
     * @return Ask
     *
     * @deprecated Use setPayer($payer)
     */
    public function setTrustee(PayerInterface $trustee = null): self
    {
        return $this->setPayer($trustee);
    }

    /**
     * Get trustee
     *
     * @return PayerInterface
     *
     * @deprecated Use getPayer()
     */
    public function getTrustee(): ?PayerInterface
    {
        return $this->getPayer();
    }
    
    /**
     * Set payer
     *
     * @param PayerInterface $payer
     *
     * @return Ask
     */
    public function setPayer(PayerInterface $payer = null): self
    {
        $this->trustee = $payer;
    
        return $this;
    }
    
    /**
     * Get trustee
     *
     * @return PayerInterface
     */
    public function getPayer(): ?PayerInterface
    {
        return $this->trustee;
    }

    /**
     * Set site
     *
     * @param SubjectInterface $site
     *
     * @return Ask
     *
     * @deprecated Use setSubject($subject)
     */
    public function setSite(SubjectInterface $site = null): self
    {
        return $this->setSubject($site);
    }

    /**
     * Get site
     *
     * @return SubjectInterface
     *
     * @deprecated Use getSubject()
     */
    public function getSite(): ?SubjectInterface
    {
        return $this->getSubject();
    }
    
    /**
     * Set subject
     *
     * @param SubjectInterface $subject
     *
     * @return Ask
     */
    public function setSubject(SubjectInterface $subject = null): self
    {
        $this->site = $subject;
    
        return $this;
    }
    
    /**
     * Get subject
     *
     * @return SubjectInterface
     */
    public function getSubject(): ?SubjectInterface
    {
        return $this->site;
    }

    /**
     * Set method
     *
     * @param CommunicationMeansInterface $method
     *
     * @return Ask
     */
    public function setMethod(CommunicationMeansInterface $method = null): self
    {
        $this->method = $method;
    
        return $this;
    }

    /**
     * Get method
     *
     * @return CommunicationMeansInterface|null
     */
    public function getMethod(): ?CommunicationMeansInterface
    {
        return $this->method;
    }

    /**
     * Set person
     *
     * @param ContactInterface $person
     *
     * @return Ask
     *
     * @deprecated Use setContact($contact)
     */
    public function setPerson(ContactInterface $person = null): self
    {
        return $this->setContact($person);
    }

    /**
     * Get person
     *
     * @return ContactInterface|null
     *
     * @deprecated Use getContact()
     */
    public function getPerson(): ?ContactInterface
    {
        return $this->getContact();
    }
    
    /**
     * Set person
     *
     * @param ContactInterface $contact
     *
     * @return Ask
     */
    public function setContact(ContactInterface $contact = null): self
    {
        $this->person = $contact;
    
        return $this;
    }
    
    /**
     * Get person
     *
     * @return ContactInterface|null
     */
    public function getContact(): ?ContactInterface
    {
        return $this->person;
    }
    
    /**
     * Vérifie si l'échéance est correct
     */
    public function isCreationBeforeMaturity(): bool
    {
        return $this->creation <= $this->maturity || $this->maturity === null;
    }

    /**
     * Get dontTreat
     *
     * @param string|null $dontTreat
     *
     * @return Ask
     * FIXME: Remove null
     */
    public function setDontTreat(?string $dontTreat = null): self
    {
        $this->dontTreat = $dontTreat;
        
        return $this;
    }
    
    /**
     * Get dontTreat
     *
     * @return string|null
     */
    public function getDontTreat(): ?string
    {
        return $this->dontTreat;
    }
    
    /**
     * Set ask
     *
     * @param string $ask
     *
     * @return Ask
     */
    public function setAsk($ask): self
    {
        $this->ask = $ask;
    
        return $this;
    }
    
    /**
     * Get ask
     *
     * @return string
     */
    public function getAsk(): ?string
    {
        return $this->ask;
    }
}
