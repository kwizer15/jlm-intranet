<?php
namespace JLM\TransmitterBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class AttributionCourrierBuilder extends CourrierBuilder
{
	private $attribution;
	
	private $police;
	
	public function __construct(AttributionInterface $attribution)
	{
		$this->attribution = $attribution;
	}
	
	public function buildContent()
	{
		$this->buildInit();
		$this->buildText();
	}
	
	public function buildInit()
	{
		$this->police = 'Times';
		$this->_pdf->addPage('P');
		$this->_pdf->setXY(100,60);
		$this->_pdf->setFont($this->police,'B',12);
		if ($this->attribution->getIndividual())
		{
			$this->_pdf->cell(0,5,$entity->getContact(),0,2);
			$this->_pdf->setFont($this->police,'',12);
			$this->_pdf->multiCell(0,5,$entity->getSite()->toString());
		}
		else
		{
			$this->_pdf->cell(0,5,$entity->getAsk()->getTrustee(),0,2);
			$this->_pdf->setFont($this->police,'',12);
			$this->_pdf->multiCell(0,5,$entity->getAsk()->getTrustee()->getAddress()->toString());
			if ($this->attribution->getContact() != null)
			{
				$this->_pdf->ln(5);
				$this->_pdf->setX(100);
				$this->_pdf->cell(0,6,'A l\'attention de '.$entity->getContact(),0,2);
			}
		}
		
		$this->_pdf->ln(5);
		$this->_pdf->setFont($this->police,'BU',12);
		$this->_pdf->cell(0,6,'Affaire',0,2);
		$this->_pdf->setFont($this->police,'',12);
		$this->_pdf->multiCell(100,6,$entity->getSite()->toString(),0);
		$this->_pdf->ln(6);
		$this->_pdf->setX(100);
		$date = $this->attribution->getCreation();
		$mois = array(1=>'janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');
		$this->_pdf->setFont($this->police,'',10);
		$this->_pdf->cell(0,6,'Saint-Soupplets, le '.$date->format('j').' '.$mois[$date->format('n')].' '.$date->format('Y'),0,2);
		$this->_pdf->ln(12);
	}
	
	public function buildText()
	{
		$this->_pdf->setFont($this->police,'',13);
		$this->_pdf->cell(0,5,'Madame, Monsieur,',0,1);
		$this->_pdf->ln(5);
		$this->_pdf->cell(0,5,'Veuillez trouver ci-joint les émetteurs commandés pour l\'affaire référencée ci-dessus,',0,1,'FJ');
		$this->_pdf->cell(0,5,'accompagnés d\'une liste d\'attribution d\'émetteurs à remplir et à garder précieusement. Celle-ci',0,1,'FJ');
		$this->_pdf->cell(53,5,'est nécessaire en cas de ',0,0,'FJ');
		$this->_pdf->setFont($this->police,'BU',13);
		$this->_pdf->cell(12,5,'perte',0,0);
		$this->_pdf->setFont($this->police,'',13);
		$this->_pdf->cell(19,5,' ou de ',0,0,'FJ');
		$this->_pdf->setFont($this->police,'BU',13);
		$this->_pdf->cell(7,5,'vol',0,0);
		$this->_pdf->setFont($this->police,'',13);
		$this->_pdf->cell(0,5,' d\'un émetteur. Sur cette liste vous répertoriez les',0,1,'FJ');
		$this->_pdf->cell(0,5,'personnes à qui vous attribuez les émetteurs.',0,1);
		$this->_pdf->ln(5);
		$this->_pdf->cell(0,5,'Nous restons à votre disposition pour tous renseignements complémentaires.',0,1);
		$this->_pdf->ln(5);
		$this->_pdf->cell(0,5,'Nous vos souhaitons bonne réception et vous prions d\'agréer, Madame, Monsieur,',0,1,'FJ');
		$this->_pdf->cell(0,5,'l\'expression de nos salutations distinguées.',0,1);
		$this->_pdf->ln(20);
		$this->_pdf->cell(0,5,'Service secrétariat',0,0,'R');
	}
}