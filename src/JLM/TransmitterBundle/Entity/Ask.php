<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JLM\AskBundle\Entity\Ask as BaseAsk;
use JLM\TransmitterBundle\Model\AttributionInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Ask extends BaseAsk
{
	/**
	 * Id
	 * @var int
	 */
	private $id;
	
	/**
	 * Propositions de contrat
	 * @var AttributionInterface
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