<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\QuoteRepository")
 */
class Quote extends Document
{
	/**
	 * @var int $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * Numéro du devis
	 * @ORM\Column(name="number", type="integer")
	 */
	private $number;
	
	/**
	 * Suiveur (pour le suivi)
	 * @var Collaborator $follower
	 * 
	 * @ORM\Column(name="follower",type="string", nullable=true)
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
	 * Texte d'intro
	 * @var string $intro
	 * 
	 * @ORM\Column(name="intro",type="text")
	 */
	private $intro;
	
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
	 * @ORM\Column(name="customer_comments", type="text", nullable=true)
	 */
	private $customerComments;
	
	/**
	 * Validé
	 * @var bool $valid
	 *
	 * @ORM\Column(name="valid",type="boolean")
	 */
	private $valid = false;
	
	/**
	 * Envoyé
	 * @var bool $send
	 *
	 * @ORM\Column(name="send",type="boolean")
	 */
	private $send = false;
	
	/**
	 * Accordé
	 * @var bool $given
	 * 
	 * @ORM\Column(name="given",type="boolean")
	 */
	private $given = false;

	/**
	 * Lignes
	 * @var ArrayCollection $lines
	 * 
	 * @ORM\OneToMany(targetEntity="QuoteLine",mappedBy="quote")
	 * @ORM\OrderBy({"position" = "ASC"})
	 */
	private $lines;
	
	/**
	 * @var SiteContact $contact
	 * 
	 * @ORM\ManyToOne(targetEntity="SiteContact")
	 */
	private $contact;
	
	/**
	 * @var string $contactCp
	 * 
	 * @ORM\Column(name="contact_cp", type="string")
	 */
	private $contactCp;
	
	/**
	 * @var float $vat
	 * 
	 * @ORM\Column(name="vat",type="decimal",precision=3,scale=3)
	 */
	private $vat;
	
	/**
	 * @var float $vatTransmitter
	 *
	 * @ORM\Column(name="vat_transmitter",type="decimal",precision=3,scale=3)
	 */
	private $vatTransmitter;
	
	/**
	 * Construteur
	 * 
	 */
	public function __construct()
	{
		$this->lines = new ArrayCollection;
	}
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     * 
     * @param string $number
     * @return Quote
     */
    public function setNumber($number)
    {
    	$this->number = $number;
    	return $this;
    }
    
    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
    	return $this->number;
    }
    
    /**
     * Set follower
     *
     * @param string $follower
     * @return Quote
     */
    public function setFollower($follower)
    {
        $this->follower = $follower;
    
        return $this;
    }

    /**
     * Get follower
     *
     * @return string 
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * Set followerCp
     *
     * @param string $followerCp
     * @return Quote
     */
    public function setFollowerCp($followerCp)
    {
        $this->followerCp = $followerCp;
    
        return $this;
    }

    /**
     * Get followerCp
     *
     * @return string 
     */
    public function getFollowerCp()
    {
        return $this->followerCp;
    }

    /**
     * Set doorCp
     *
     * @param string $doorCp
     * @return Quote
     */
    public function setDoorCp($doorCp)
    {
        $this->doorCp = $doorCp;
    
        return $this;
    }

    /**
     * Get doorCp
     *
     * @return string 
     */
    public function getDoorCp()
    {
        return $this->doorCp;
    }

    /**
     * Set paymentRules
     *
     * @param string $paymentRules
     * @return Quote
     */
    public function setPaymentRules($paymentRules)
    {
        $this->paymentRules = $paymentRules;
    
        return $this;
    }

    /**
     * Get paymentRules
     *
     * @return string 
     */
    public function getPaymentRules()
    {
        return $this->paymentRules;
    }

    /**
     * Set deliveryRules
     *
     * @param string $deliveryRules
     * @return Quote
     */
    public function setDeliveryRules($deliveryRules)
    {
        $this->deliveryRules = $deliveryRules;
    
        return $this;
    }

    /**
     * Get deliveryRules
     *
     * @return string 
     */
    public function getDeliveryRules()
    {
        return $this->deliveryRules;
    }

    /**
     * Set customerComments
     *
     * @param string $customerComments
     * @return Quote
     */
    public function setCustomerComments($customerComments)
    {
        $this->customerComments = $customerComments;
    
        return $this;
    }

    /**
     * Get customerComments
     *
     * @return string 
     */
    public function getCustomerComments()
    {
        return $this->customerComments;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     * @return Quote
     */
    public function setValid($valid = true)
    {
    	$this->valid = (bool)$valid;
    
    	return $this;
    }
    
    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
    	return $this->valid;
    }
    
    /**
     * Is valid
     *
     * @return boolean
     */
    public function isValid()
    {
    	return $this->getValid();
    }
    
    /**
     * Set send
     *
     * @param boolean $send
     * @return Quote
     */
    public function setSend($send = true)
    {
    	$this->send = (bool)$send;
    
    	return $this;
    }
    
    /**
     * Get send
     *
     * @return boolean
     */
    public function getSend()
    {
    	return $this->send;
    }
    
    /**
     * Is send
     *
     * @return boolean
     */
    public function isSend()
    {
    	return $this->getSend();
    }
    
    /**
     * Set given
     *
     * @param boolean $given
     * @return Quote
     */
    public function setGiven($given = true)
    {
        $this->given = (bool)$given;
    
        return $this;
    }

    /**
     * Get given
     *
     * @return boolean 
     */
    public function getGiven()
    {
        return $this->given;
    }
    
    /**
     * Is given
     *
     * @return boolean
     */
    public function isGiven()
    {
    	return $this->getGiven();
    }

    /**
     * Set door
     *
     * @param JLM\ModelBundle\Entity\Door $door
     * @return Quote
     */
    public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
    {
        $this->door = $door;
    
        return $this;
    }

    /**
     * Get door
     *
     * @return JLM\ModelBundle\Entity\Door 
     */
    public function getDoor()
    {
        return $this->door;
    }
    
    public function getIntro()
    {
    	return $this->intro;
    }
    
    public function setIntro($intro)
    {
    	$this->intro = $intro;
    	return $this;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Quote
     */
    public function setContact($contact)
    {
    	$this->contact = $contact;
    
    	return $this;
    }
    
    /**
     *
     * @return string
     */
    public function getContact()
    {
    	return $this->contact;
    }
    
    /**
     * Set contactCp
     *
     * @param string $contactCp
     * @return Quote
     */
    public function setContactCp($contactCp)
    {
    	$this->contactCp = $contactCp;
    
    	return $this;
    }
    
    /**
     * Get contactCp
     *
     * @return string
     */
    public function getContactCp()
    {
    	return $this->contactCp;
    }
    
    /**
     * Add lines
     *
     * @param JLM\ModelBundle\Entity\QuoteLine $lines
     * @return Quote
     */
    public function addLine(\JLM\ModelBundle\Entity\QuoteLine $lines)
    {
    	$lines->setQuote($this);
        $this->lines[] = $lines;
    	
        return $this;
    }

    /**
     * Remove lines
     *
     * @param JLM\ModelBundle\Entity\QuoteLine $lines
     */
    public function removeLine(\JLM\ModelBundle\Entity\QuoteLine $lines)
    {
    	$lines->setQuote();
        $this->lines->removeElement($lines);
    }

    /**
     * Get lines
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLines()
    {
        return $this->lines;
    }
    
    /**
     * Set vat
     *
     * @param float $vat
     * @return Quote
     */
    public function setVat($vat)
    {
    	$this->vat = $vat;
    
    	return $this;
    }
    
    /**
     * Get vat
     *
     * @return float
     */
    public function getVat()
    {
    	return $this->vat;
    }
    
    /**
     * Set vatTransmitter
     *
     * @param float $vatTransmitter
     * @return Quote
     */
    public function setVatTransmitter($vat)
    {
    	$this->vatTransmitter = $vat;
    
    	return $this;
    }
    
    /**
     * Get vatTransmitter
     *
     * @return float
     */
    public function getVatTransmitter()
    {
    	return $this->vatTransmitter;
    }
    
    /**
     * Get Total HT
     */
    public function getTotalPrice()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    		$total += $line->getPrice();
    	$total *= (1-$this->getDiscount());
    	return $total;
    }
    
    /**
     * Get Total TVA
     */
    public function getTotalVat()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    		$total += $line->getVatValue();
    	$total *= (1-$this->getDiscount());
    	return $total;
    }
    
    /**
     * Get Total TTC
     */
    public function getTotalPriceAti()
    {
    	$total = 0;
    	foreach ($this->getLines() as $line)
    		$total += $line->getPriceAti();
    	$total *= (1-$this->getDiscount());
    	return $total;
    }
    
    /**
     * Get PDF content
     */
    public function getPdf()
    {
    	$entity = $this;
    	$pdf = new \FPDI();
    	
    	// Template
    	$pageCount = $pdf->setSourceFile($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/pdf/devis.pdf');
    	$onlyPage = $pdf->importPage(1, '/MediaBox');
    	//	$firstPage = $pdf->importPage(2, '/MediaBox');
    	//	$middlePage = $pdf->importPage(3, '/MediaBox');
    	//	$endPage = $pdf->importPage(4 '/MediaBox');
    	 
    	// Premiere page
    	$pdf->addPage();
    	$pdf->useTemplate($onlyPage);
    	
    	/* Cadrillage */
    	/*  for ($x = 0; $x < 300; $x += 10)
    	 for ($y  = 0; $y < 300; $y += 10)
    		$pdf->rect($x,$y,10,10);
    	* @Secure(roles="ROLE_USER")
    	*/
    	
    	$pdf->setFillColor(200);
    	$pdf->setLeftMargin(4);
    	// Follower
    	$pdf->setFont('Arial','BU',11);
    	$pdf->setY(63);
    	$pdf->cell(20,7,utf8_decode('suivi par : '),0,0);
    	$pdf->setFont('Arial','B',11);
    	$pdf->cell(65,7,utf8_decode($entity->getFollowerCp()),0,1);
    	
    	// Door
    	$pdf->setFont('Arial','BU',11);
    	$pdf->cell(15,5,utf8_decode('affaire : '),0,0);
    	$pdf->setFont('Arial','',11);
    	$pdf->multiCell(90,5,utf8_decode($entity->getDoorCp()));
    	
    	 
    	// Trustee
    	$pdf->setXY(130,69.5);
    	$pdf->multiCell(80,5,utf8_decode($entity->getTrusteeName().chr(10).$entity->getTrusteeAddress()));
    	
    	// Contact
    	$pdf->setFont('Arial','',10);
    	$pdf->setXY(130,93);
    	$pdf->cell(40,5,utf8_decode('à l\'attention de '.$entity->getContactCp()),0,1);
    	
    	// Création
    	$pdf->setFont('Arial','B',10);
    	$pdf->setY(93);
    	$pdf->cell(22,6,'Date','LRT',0,'C',true);
    	$pdf->cell(19,6,utf8_decode('Devis n°'),'LRT',1,'C',true);
    	$pdf->setFont('Arial','',10);
    	$pdf->cell(22,6,$entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
    	$pdf->cell(19,6,$entity->getNumber(),'LRB',1,'C');
    	
    	$pdf->cell(0,3,'',0,1);
    	
    	// En tête lignes
    	$pdf->setFont('Arial','B',10);
    	
    	$pdf->cell(22,6,utf8_decode('Référence'),1,0,'C',true);
    	$pdf->cell(19,6,utf8_decode('Quantité'),1,0,'C',true);
    	$pdf->cell(101,6,utf8_decode('Désignation'),1,0,'C',true);
    	$pdf->cell(24.5,6,utf8_decode('Prix U.H.T'),1,0,'C',true);
    	$pdf->cell(25,6,utf8_decode('Prix H.T'),1,1,'C',true);
    	
    	
    	
    	// Lignes
    	$pdf->setFont('Arial','',10);
    	$lines = $entity->getLines();
    	foreach ($lines as $line)
    	{
    		$pdf->cell(22,7,utf8_decode($line->getReference()),'RL',0);
    		$pdf->cell(19,7,$line->getQuantity(),'RL',0,'R');
    		$pdf->cell(101,7,utf8_decode($line->getDesignation()),'RL',0);
    		$pdf->cell(24.5,7,number_format($line->getUnitPrice()*(1-$line->getDiscount()),2,',',' ').' '.chr(128),'RL',0,'R');
    		$pdf->cell(25,7,number_format($line->getPrice(),2,',',' ').' '.chr(128),'RL',1,'R');
    		if ($line->getShowDescription())
    		{
    			$y = $pdf->getY() - 2;
    			$pdf->setXY(45,$y);
    			$pdf->setFont('Arial','I',10);
    			$pdf->multiCell(101,5,utf8_decode($line->getDescription()),0,1);
    			$pdf->setFont('Arial','',10);
    			$h = $pdf->getY() - $y;
    			$pdf->setY($y);
    			$pdf->cell(22,$h,'','RL',0);
    			$pdf->cell(19,$h,'','RL',0);
    			$pdf->cell(101,$h,'','RL',0);
    			$pdf->cell(24.5,$h,'','RL',0);
    			$pdf->cell(25,$h,'','RL',1);
    	
    		}
    	}
    	$h=20;
    	$pdf->cell(22,$h,'','RL',0);
    	$pdf->cell(19,$h,'','RL',0);
    	$pdf->cell(101,$h,'','RL',0);
    	$pdf->cell(24.5,$h,'','RL',0);
    	$pdf->cell(25,$h,'','RL',1);
    	$pdf->setFont('Arial','B',10);
    	$pdf->cell(166.5,6,'MONTANT TOTAL H.T',1,0,'R',true);
    	$pdf->cell(25,6,number_format($entity->getTotalPrice(),2,',',' ').' '.chr(128),1,1,'R',true);
    	 
    	$pdf->setFont('Arial','',10);
    	$pdf->cell(22,6,'Tx T.V.A',1,0,'R');
    	$pdf->cell(19,6,number_format($entity->getVat()*100,1,',',' ').' %',1,0,'R');
    	$pdf->cell(101,6,'',1,0);
    	$pdf->setFont('Arial','B',10);
    	$pdf->cell(24.5,6,'montant TVA',1,0);
    	$pdf->cell(25,6,number_format($entity->getTotalVat(),2,',',' ').' '.chr(128),1,1,'R');
    	 
    	$pdf->cell(142,6,'',1,0);
    	$pdf->cell(24.5,6,'TOTAL T.T.C',1,0);
    	$pdf->cell(25,6,number_format($entity->getTotalPriceAti(),2,',',' ').' '.chr(128),1,1,'R');
    	 
    	$pdf->cell(0,6,'',0,1);
    	 
    	// Observations
    	$pdf->setFont('Arial','',10);
    	$pdf->cell(142,6,utf8_decode('Réservé au client'),1,0,'C',true);
    	$pdf->cell(49.5,6,utf8_decode('BON POUR ACCORD'),1,1,'C',true);
    	$pdf->setFont('Arial','IU',10);
    	$pdf->cell(142,6,utf8_decode('Observations éventuelles'),'LR',0,'C');
    	$pdf->cell(49.5,6,utf8_decode('Tampon, date et signature'),'LR',1,'C');
    	$pdf->cell(142,20,'','LRB',0);
    	$pdf->cell(49.5,20,'','LRB',1);
    	 
    	// Réglement
    	$pdf->cell(0,6,'',0,1);
    	$pdf->setFont('Arial','BU',10);
    	$pdf->cell(0,5,utf8_decode('Réglement'),0,1);
    	$pdf->setFont('Arial','',10);
    	$pdf->cell(0,5,utf8_decode($entity->getPaymentRules()),0,1);
    	 
    	// Délais
    	$pdf->cell(0,6,'',0,1);
    	$pdf->setFont('Arial','BU',10);
    	$pdf->cell(0,5,utf8_decode('Délais'),0,1);
    	$pdf->setFont('Arial','',10);
    	$pdf->cell(0,5,utf8_decode($entity->getDeliveryRules()),0,1);
    	 
    	// Délais
    	 
    	$ct = substr($entity->getContactCp(),0,2);
    	if ($ct == 'M.')
    		$who = 'Monsieur';
    	elseif ($ct == 'Mm')
    	$who = 'Madame';
    	elseif ($ct == 'Ml')
    	$who = 'Mademoiselle';
    	else
    		$who = 'Madame, Monsieur';
    	$pdf->cell(0,6,'',0,1);
    	$pdf->multiCell(0,5,utf8_decode('Nous vous en souhaitons bonne récéption et vous prions d\'agréer, '.$who.' l\'expression de nos'.chr(10).'sentiments les meilleurs.'),0,1);
    	 
    	 
    	return $pdf->Output('','S');
    }
}