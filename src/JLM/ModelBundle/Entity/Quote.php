<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity
 */
class Quote extends Document
{
	/**
	 * Numéro du devis
	 * @var int $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @todo Construire automatiquement
	 */
	private $id;
	
	/**
	 * Suiveur (pour le suivi)
	 * @var Collaborator $follower
	 * 
	 * @ORM\Column(name="collaborator",type="string")
	 */
	private $follower;
	
	/**
	 * Suiveur (pour le devis)
	 * @var string $followerCp
	 *
	 * @ORM\Column(name="follower_cp",type="string")
	 */
	private $followerCp;
	
	/**
	 * Porte concernée (pour le suivi)
	 * @var Door $door
	 * 
	 * @ORM\ManyToOne(targetEntity="Door")
	 */
	private $door;
	
	/**
	 * Porte concernée (pour le devis)
	 * @var string $doorCp
	 *
	 * @ORM\Column(name="door_cp",type="text")
	 */
	private $doorCp;
	
	/**
	 * @var string $paymentRules
	 *
	 * @ORM\Column(name="payment_rules", type="string", length=255)
	 */
	private $paymentRules;
	
	/**
	 * @var string $deliveryRules
	 *
	 * @ORM\Column(name="delivery_rules", type="string", length=255)
	 */
	private $deliveryRules;
	
	/**
	 * @var string $customerComments
	 *
	 * @ORM\Column(name="customer_comments", type="text")
	 */
	private $customerComments;
	
	/**
	 * Accordé
	 * @var bool $given
	 * 
	 * @ORM\Column(name="given",type="boolean")
	 */
	private $given;
}