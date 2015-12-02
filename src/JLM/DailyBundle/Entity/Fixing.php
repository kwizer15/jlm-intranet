<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JLM\AskBundle\Model\CommunicationMeansInterface;
use JLM\DailyBundle\Model\PartFamilyInterface;
use JLM\DailyBundle\Model\FixingInterface;
use JLM\ContactBundle\Entity\Company;

/**
 * Plannification d'une panne
 * JLM\DailyBundle\Entity\Fixing
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Fixing extends Intervention implements FixingInterface
{
	/**
	 * Date de la demande
	 * @Assert\DateTime
	 */
	private $askDate;
	
	/**
	 * Méthode de la demande
	 */
	private $askMethod;
	
	/**
	 * Cause du dépannage
	 * @var FixingDue $due;
	 * @Assert\Valid
	 */
	private $due;
	
	/**
	 * Action
	 * @var FixingDone $done;
	 * @Assert\Valid
	 */
	private $done;
	
	/**
	 * Famille de pièce
	 * @var PartFamilyInterface
	 */
	private $partFamily;
	
	/**
	 * Constat
	 * @var string $observation
	 */
	private $observation;
	
	/**
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'fixing';
	}
	
	/**
	 * Get askDate
	 * 
	 * @return \DateTime
	 */
	public function getAskDate()
	{
		return $this->askDate;
	}
	
	/**
	 * Set askDate
	 * 
	 * @param \DateTime $date
	 * @return Fixing
	 */
	public function setAskDate(\DateTime $date = null)
	{
		$this->askDate = $date;
		
		return $this;
	}
	
	/**
	 * Get askMethod
	 *
	 * @return CommunicationMeansInterface
	 */
	public function getAskMethod()
	{
		return $this->askMethod;
	}
	
	/**
	 * Set askMethod
	 *
	 * @param CommunicationMeansInterface $method
	 * @return Fixng
	 */
	public function setAskMethod(CommunicationMeansInterface $method = null)
	{
		$this->askMethod = $method;
		
		return $this;
	}
	
	/**
	 * Get due
	 * 
	 * @return FixingDue
	 */
	public function getDue()
	{
		return $this->due;
	}
	
	/**
	 * Set due
	 * 
	 * @param FixingDue $due
	 * @return Fixing
	 */
	public function setDue(FixingDue $due = null)
	{
		$this->due = $due;
		
		return $this;
	}
	
	/**
	 * Get done
	 *
	 * @return FixingDone
	 */
	public function getDone()
	{
		return $this->done;
	}
	
	/**
	 * Set done
	 *
	 * @param FixingDone $done
	 * @return Fixing
	 */
	public function setDone(FixingDone $done = null)
	{
		$this->done = $done;
		
		return $this;
	}
	
	/**
	 * Get part family
	 *
	 * @return PartFamilyInterface
	 */
	public function getPartFamily()
	{
		return $this->partFamily;
	}
	
	/**
	 * Set part family
	 *
	 * @param PartFamilyInterface $partFamily
	 * @return self
	 */
	public function setPartFamily(PartFamilyInterface $partFamily = null)
	{
		$this->partFamily = $partFamily;
	
		return $this;
	}
	
	/**
	 * Get observation
	 */
	public function getObservation()
	{
		return $this->observation;
	}
	
	/**
	 * Set observation
	 * 
	 * @param string $observation
	 * @return self
	 */
	public function setObservation($observation)
	{
		$this->observation = (string)$observation;
		
		return $this;
	}
	
	/**
	 * Get customer report
	 * @return string
	 */
	public function getCustomerReport()
	{
		$out = 'Nous avons constaté ';
		$nothing = $out.'après plusieurs essais que l\'installation était fonctionnelle.';
		$part = ($this->getPartFamily() === null) ? 'aucun' : strtolower($this->getPartFamily()->getName());
		if ($part == 'aucun')
		{
			return $nothing;
		}
		$out.= 'un';
		$due = $this->getDue();
		if ($due !== null)
		{
			$cause = ($due->getId() != 4) ? 'e '.strtolower($due->getName()) : ' dysfonctionnement';
			$out .= $cause.' sur les élements d';
			$suite = (in_array(substr($part,0,1),array('a','e','i','o','u'))) ? '\'' : 'e ';
				
			return $out.$suite.$part.'.';
		}
		
		return $nothing;
	}
	
	/**
	 * Get customer actions
	 * @return string
	 */
	public function getCustomerActions()
	{
		// null
		// 		done == constat
		
		// Nous avons procédé aux réparations nécessaires
		//		 done == remplacer || done == réparé || work->isClosed()
		
		// Un devis va vous être envoyé
		// Le devis n°xxxxxx vous a été envoyé le xx/xx/xxxx
		// 
		
		$out = 'Nous avons constaté ';
		$nothing = $out.'après plusieurs essais que l\'intallation était fonctionnelle.';
		$part = ($this->getPartFamily() === null) ? 'aucun' : strtolower($this->getPartFamily()->getName());
		if ($part == 'aucun')
		{
			return $nothing;
		}
		$out.= 'un';
		$due = $this->getDue();
		if ($due !== null)
		{
			$cause = ($due->getId() != 4) ? 'e '.strtolower($due->getName()) : ' dysfonctionnement';
			$out .= $cause.' sur les élements d';
			$suite = (in_array(substr($part,0,1),array('a','e','i','o','u'))) ? '\'' : 'e ';
	
			return $out.$suite.$part.'.';
		}
	
		return $nothing;
	}
}