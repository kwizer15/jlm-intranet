<?php

namespace JLM\TransmitterBundle\Entity;

use JLM\TransmitterBundle\Entity\Attribution;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JLM\AskBundle\Entity\Ask as BaseAsk;

/**
 * Commande d'émetteurs
 * JLM\TransmitterBundle\Entity\Ask
 *
 * @ORM\Table(name="transmitters_ask")
 * @ORM\Entity(repositoryClass="JLM\TransmitterBundle\Entity\AskRepository")
 */
class Ask extends BaseAsk
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * Propositions de contrat
	 * @ORM\OneToMany(targetEntity="Attribution",mappedBy="ask")
	 */
	private $attributions;
	
	/**
	 * Get Id
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Dossier de stockage des documents uploadés
	 */
	protected function getUploadDir()
	{
		return 'uploads/documents/transmitter/ask';
	}
	
	/**
     * Constructor
     */
	public function __construct()
	{
	    $this->attributions = new \Doctrine\Common\Collections\ArrayCollection();
	}
		
	/**
	 * Add attribution
	 *
	 * @param \JLM\TransmitterBundle\Entity\Attribution $attribution
	 * @return AskContract
	 */
	public function addAttribution(\JLM\TransmitterBundle\Entity\Attribution $attribution)
	{
	    $this->attributions[] = $attribution;
		
	    return $this;
	}
		
	/**
	 * Remove attribution
	 *
	 * @param \JLM\TransmitterBundle\Entity\Attribution $attribution
	 */
	public function removeAttribution(\JLM\TransmitterBundle\Entity\Attribution $attribution)
	{
	    $this->attributions->removeElement($attribution);
	}
		
	/**
	 * Get attributions
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getAttributions()
	{
	    return $this->attributions;
	}
}