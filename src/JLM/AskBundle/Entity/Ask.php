<?php

/*
 * This file is part of the JLMAskBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\AskBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JLM\ModelBundle\Entity\UploadDocument;
use JLM\AskBundle\Model\PayerInterface;
use JLM\AskBundle\Model\SubjectInterface;
use JLM\AskBundle\Model\AskInterface;
use JLM\AskBundle\Model\CommunicationMeansInterface;
use JLM\AskBundle\Model\ContactInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class Ask extends UploadDocument implements AskInterface
{
	/**
	 * Syndic
	 * @var PayerInterface
	 */
	private $trustee;
	
	/**
	 * Affaire
	 * @var SubjectInterface
	 */
	private $site;
	
	/**
	 * Méthode de la demande
	 * @var CommunicationMeansInterface
	 */
	private $method;
	
	/**
	 * Date de la demande
	 * @var \DateTime
	 */
	private $creation;
	
	/**
	 * Date d'échéance
	 * @var \DateTime
	 */
	private $maturity;
	
	/**
	 * Contact
	 * @var ContactInterface
	 */
	private $person;

	/**
	 * Ne pas traiter
	 * @var string
	 */
	private $dontTreat;

	/**
	 * Résumé de la demande
	 * @var string
	 */
	private $ask;
	
    /**
     * Set creation
     *
     * @param \DateTime $creation
     * @return self
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;
    
        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime 
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set maturity
     *
     * @param \DateTime $maturity
     * @return self
     */
    public function setMaturity($maturity)
    {
        $this->maturity = $maturity;
    
        return $this;
    }

    /**
     * Get maturity
     *
     * @return \DateTime 
     */
    public function getMaturity()
    {
        return $this->maturity;
    }

    /**
     * Set trustee
     *
     * @param PayerInterface $trustee
     * @return self
     * @deprecated Use setPayer($payer)
     */
    public function setTrustee(PayerInterface $trustee = null)
    {
        return $this->setPayer($trustee);
    }

    /**
     * Get trustee
     *
     * @return PayerInterface
     * @deprecated Use getPayer()
     */
    public function getTrustee()
    {
        return $this->getPayer();
    }
    
    /**
     * Set payer
     *
     * @param PayerInterface $payer
     * @return self
     */
    public function setPayer(PayerInterface $payer = null)
    {
        $this->payer = $payer;
    
        return $this;
    }
    
    /**
     * Get trustee
     *
     * @return PayerInterface
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * Set site
     *
     * @param SubjectInterface $site
     * @return self
     * @deprecated Use setSubject($subject)
     */
    public function setSite(SubjectInterface $site = null)
    {
        return $this->setSubject($site);
    }

    /**
     * Get site
     *
     * @return SubjectInterface
     * @deprecated Use getSubject()
     */
    public function getSite()
    {
        return $this->getSubject();
    }
    
    /**
     * Set subject
     *
     * @param SubjectInterface $site
     * @return self
     */
    public function setSubject(SubjectInterface $subject = null)
    {
        $this->site = $subject;
    
        return $this;
    }
    
    /**
     * Get subject
     *
     * @return SubjectInterface
     */
    public function getSubject()
    {
        return $this->site;
    }

    /**
     * Set method
     *
     * @param CommunicationMeans $method
     * @return self
     */
    public function setMethod(CommunicationMeansInterface $method = null)
    {
        $this->method = $method;
    
        return $this;
    }

    /**
     * Get method
     *
     * @return CommunicationMeans
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set person
     *
     * @param ContactInterface $person
     * @return self
     * @deprecated Use setContact($contact)
     */
    public function setPerson(ContactInterface $person = null)
    {
        return $this->setContact($person);
    }

    /**
     * Get person
     *
     * @return ContactInterface
     * @deprecated Use getContact()
     */
    public function getPerson()
    {
        return $this->getContact();
    }
    
    /**
     * Set person
     *
     * @param ContactInterface $person
     * @return self
     */
    public function setContact(ContactInterface $contact = null)
    {
        $this->person = $$contact;
    
        return $this;
    }
    
    /**
     * Get person
     *
     * @return ContactInterface
     */
    public function getContact()
    {
        return $this->person;
    }
    
    /**
     * Vérifie si l'échéance est correct
     */
    public function isCreationBeforeMaturity()
    {
    	return $this->creation <= $this->maturity || $this->maturity === null;
    }
    
    /**
     * Get dontTreat
     * @return string|null
     */
    public function setDontTreat($dontTreat = null)
    {
    	$this->dontTreat = $dontTreat;
    	
    	return $this;
    }
    
    /**
     * Get dontTreat
     * @return string|null
     */
    public function getDontTreat()
    {
    	return $this->dontTreat;
    }
    
    /**
     * Set ask
     *
     * @param string $ask
     * @return self
     */
    public function setAsk($ask)
    {
    	$this->ask = $ask;
    
    	return $this;
    }
    
    /**
     * Get ask
     *
     * @return string
     */
    public function getAsk()
    {
    	return $this->ask;
    }
}