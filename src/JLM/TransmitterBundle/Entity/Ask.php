<?php

namespace JLM\TransmitterBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JLM\AskBundle\Entity\Ask as BaseAsk;
use JLM\TransmitterBundle\Model\AttributionInterface;

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
	 * {@inheritdoc}
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
	 * @param AttributionInterface $attribution
	 * @return bool
	 */
	public function addAttribution(AttributionInterface $attribution)
	{
	    $this->attributions[] = $attribution;
		
	    return true;
	}
		
	/**
	 * Remove attribution
	 *
	 * @param AttributionInterface $attribution
	 * @return bool
	 */
	public function removeAttribution(AttributionInterface $attribution)
	{
	    return $this->attributions->removeElement($attribution);
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