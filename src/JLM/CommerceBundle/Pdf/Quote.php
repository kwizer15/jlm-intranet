<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Pdf;

use JLM\CommerceBundle\Pdf\CommercialPart;
use JLM\ModelBundle\Entity\Door;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Quote extends CommercialPart
{	
	private $st = array('price'=> 0.0,'ati'=>0.0);
	
	/**
	 * {@inheritdoc}
	 */
	protected function getColsize()
	{
	    return array(100,7,24,24,13,24);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function _header($options)
	{
		// Follower
		$this->setFont('Arial','B',11);
	//	$this->setY(63);
		$this->cell(20,7,'suivi par : ',0,0);
		$this->setFont('Arial','B',11);
		$this->cell(65,7,$this->entity->getQuote()->getFollowerCp(),0,1);
		
		// Door
		$this->setFont('Arial','B',11);
		$this->cell(15,5,'affaire : ',0,0);
		$this->setFont('Arial','I',11);
		$y = $this->getY();
		$this->multiCell(90,5,$this->entity->getQuote()->getDoorCp(),0);
		$this->setXY(120,$y);
		// Trustee
	//	$this->rect(86,47,99,39);
		$this->setFont('Arial','B',11);
		$this->cell(0,5,$this->entity->getQuote()->getTrusteeName(),0,2);
		$this->setFont('Arial','',11);
		$this->multiCell(0,5,$this->entity->getQuote()->getTrusteeAddress());
		$this->ln(10);
		
		// Création haut
		$this->setFont('Arial','B',10);
		$this->cell(22,6,'Date','LRT',0,'C',true);
		$this->cell(22,6,'Devis n°','LRT',0,'C',true);
		$door = $this->entity->getQuote()->getDoor();
		if ($door instanceof Door)
		{
			if ($door->getCode())
			{
				$this->cell(22,6,'Code JLM','LRT',0,'C',true);
			}
		}
		
		// Contact
		$this->setFont('Arial','',10);
		
		$this->setX(120);
		$this->cell(0,5,'à l\'attention de '.$this->entity->getQuote()->getContactCp(),0,1);
		
		// Création bas
		$this->setFont('Arial','',10);
		$this->cell(22,6,$this->entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
		$this->cell(22,6,$this->entity->getNumber(),'LRB',0,'C');
		$hasCode = false;
		if ($door instanceof Door)
		{
			if ($door->getCode())
			{
				$this->cell(22,6,$door->getCode(),'LRB',1,'C');
				$hasCode = true;
			}
		}
		
		if (!$hasCode)
		{
			$this->ln(6);
		}
		$this->ln(6);
		$this->multiCell(0,5,$this->entity->getIntro(),0,1);
		$this->ln(3);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function _line($line)
	{
		if ($line->getReference() == 'ST')
		{
			$this->setFont('Arial','BI',10);
			$this->cell($this->colsize[0],8,'Sous-total '.$line->getDesignation(),'RL',0,'R');
			$this->cell($this->colsize[1],8,'','RL',0,'R');
			$this->cell($this->colsize[2],8,'','RL',0,'R');
			$this->cell($this->colsize[3],8,number_format($this->st['price'],2,',',' ').' €','RL',0,'R');
			$this->cell($this->colsize[4],8,'','RL',0,'R');
			$this->cell($this->colsize[5],8,number_format($this->st['ati'],2,',',' ').' €','RL',1,'R');
			$this->st = array('price'=> 0.0, 'ati'=> 0.0);
		}
		elseif ($line->getReference() == 'TITLE')
		{
			$this->setFont('Arial','B',10);
			$this->cell($this->colsize[0],8,$line->getDesignation(),'RTL',0,'L');
			$this->cell($this->colsize[1],8,'','RTL',0);
			$this->cell($this->colsize[2],8,'','RTL',0);
			$this->cell($this->colsize[3],8,'','RTL',0);
			$this->cell($this->colsize[4],8,'','RTL',0);
			$this->cell($this->colsize[5],8,'','RTL',1);
		}
		else {
			$this->setFont('Arial','',10);
		//	$this->cell($this->colsize[0],8,$line->getReference(),'RL',0);
			$this->cell($this->colsize[0],8,$line->getDesignation(),'RL',0);
			$this->cell($this->colsize[1],8,$line->getQuantity(),'RL',0,'R');
			$this->cell($this->colsize[2],8,number_format($line->getUnitPrice()*(1-$line->getDiscount()),2,',',' ').' €','RL',0,'R');
			$this->cell($this->colsize[3],8,number_format($line->getPrice(),2,',',' ').' €','RL',0,'R');
			$this->cell($this->colsize[4],8,number_format($line->getVat()*100,1,',',' ').' %','RL',0,'R');
			$this->cell($this->colsize[5],8,number_format($line->getPriceAti(),2,',',' ').' €','RL',1,'R');
			$this->st['price'] += $line->getPrice();
			$this->st['ati'] += $line->getPriceAti();
		}
			
		if ($line->getShowDescription())
		{
			$text = explode(chr(10),$line->getDescription());
			$y = $this->getY() - 2;
			$this->setY($y);
			$this->setFont('Arial','I',10);
			foreach ($text as $l)
			{
//				$this->cell($this->colsize[0],5,'','RL',0);
				$this->cell($this->colsize[0],5,$l,'RL');
				$this->cell($this->colsize[1],5,'','RL',0);
				$this->cell($this->colsize[2],5,'','RL',0);
				$this->cell($this->colsize[3],5,'','RL',0);
				$this->cell($this->colsize[4],5,'','RL',0);
				$this->cell($this->colsize[5],5,'','RL',1);
			}
			$this->setFont('Arial','',10);
		}
		
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function _footer()
	{
		$y = $this->getY();
		if ($y > 210)
		{
			$this->addPage();
			$y = $this->getY();
		}
		$this->end = true;
		$h = 210 - $y;
		$this->cell($this->colsize[0],$h,'','RL',0);
		$this->cell($this->colsize[1],$h,'','RL',0);
		$this->cell($this->colsize[2],$h,'','RL',0);
		$this->cell($this->colsize[3],$h,'','RL',0);
		$this->cell($this->colsize[4],$h,'','RL',0);
		$this->cell($this->colsize[5],$h,'','RL',1);
		
		// Réglement
		$this->setFont('Arial','B',10);
		$this->cell($this->colsize[0]+$this->colsize[1]+$this->colsize[2]+$this->colsize[3]+$this->colsize[4],6,'MONTANT TOTAL H.T',1,0,'R',true);
		$this->cell($this->colsize[5],6,number_format($this->entity->getTotalPrice(),2,',',' ').' €',1,1,'R',true);
		
		$this->setFont('Arial','B',10);
		$cs = $this->colsize[0]+$this->colsize[1]+$this->colsize[2]+$this->colsize[4];
		if ($this->entity->getQuote()->getVat() > 0.1)
			$this->cell($cs,6,'Si T.V.A. à 10 %, merci de nous fournir l\'attestation',1,0);
		else $this->cell($cs,6,'',1,0);
		
		
		$this->cell($this->colsize[3],6,'montant TVA',1,0);
		$this->cell($this->colsize[5],6,number_format($this->entity->getTotalVat(),2,',',' ').' €',1,1,'R');
		
		$this->cell($cs,6,'',1,0);
		$this->cell($this->colsize[3],6,'TOTAL T.T.C',1,0);
		$this->cell($this->colsize[5],6,number_format($this->entity->getTotalPriceAti(),2,',',' ').' €',1,1,'R');
		
		$this->ln(6);
		
		$y = $this->getY();
		$this->setFont('Arial','BU',10);
		$this->cell(20,5,'Réglement',0,0);
		$this->setFont('Arial','',10);
		$this->cell($cs-15,5,$this->entity->getPaymentRules(),0,1);
	
		// Délais
		$this->ln(3);
		$this->setFont('Arial','BU',10);
		$this->cell(15,5,'Délais',0,0);
		$this->setFont('Arial','',10);
		$this->cell($cs-15,5,$this->entity->getDeliveryRules(),0,1);
		
		// Politesse
		
		$ct = substr($this->entity->getQuote()->getContactCp(),0,2);
		if ($ct == 'M.')
			$who = 'Monsieur';
		elseif ($ct == 'Mm')
		$who = 'Madame';
		elseif ($ct == 'Ml')
		$who = 'Mademoiselle';
		else
			$who = 'Madame, Monsieur';
		$this->ln(3);
		$this->multiCell($cs,5,'Nous vous en souhaitons bonne réception et vous prions d\'agréer, '.$who.' l\'expression de nos sentiments les meilleurs.',0,1);
		$this->ln(3);
		$this->setFont('Arial','B',7);
		$this->cell(38,4,'Clause de réserve de propriété: ','',0);
		$this->setFont('Arial','',7);
		$this->cell(0,4,'JLM conserve l\'entière propriété des marchandises jusqu\'au complet paiement du prix facturé.','',1);
		$this->setFont('Arial','B',7);
		$this->cell(13,4,'Escompte ','',0);
		$this->setFont('Arial','',7);
		$this->cell(0,4,'0,00 % pour paiement anticipé.','',1);
		$this->setFont('Arial','B',7);
		$this->cell(11,4,'Pénalité ','',0);
		$this->setFont('Arial','',7);
		$this->cell(0,4,'pour non respect de la date d\'échéance: 1,3 %/mois. Loi n° 92-144 du 31/12/92','',1);
		// Signature
		$this->setFont('Arial','',10);
		$this->setXY(152,$y);
		$this->cell(50,6,'BON POUR ACCORD',1,1,'C',true);
		$this->setFont('Arial','IU',10);
		$this->setX(152);
		$this->cell(50,6,'Tampon, date et signature','LR',1,'C');
		$this->setX(152);
		$this->cell(50,25,'','LRB',1);
		
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDocumentName()
	{
	    return 'Devis';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function tabHeader()
	{
		$this->setFont('Arial','B',10);
		//	$this->cell($this->colsize[0],6,'Référence',1,0,'C',true);
		$this->cell($this->colsize[0],6,'Désignation',1,0,'C',true);
		$this->cell($this->colsize[1],6,'Qté',1,0,'C',true);
		$this->cell($this->colsize[2],6,'Prix U.H.T',1,0,'C',true);
		$this->cell($this->colsize[3],6,'Prix H.T',1,0,'C',true);
		$this->cell($this->colsize[4],6,'TVA',1,0,'C',true);
		$this->cell($this->colsize[5],6,'Prix TTC',1,1,'C',true);
	}
}