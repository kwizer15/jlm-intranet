<?php
namespace JLM\OfficeBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;
use \JLM\OfficeBundle\Entity\Bill;

class BillBoost extends FPDFext
{
	private $police;
	
	public static function get($entities)
	{
		$pdf = new self();
		foreach ($entities as $entity)
		{
			$pdf->_init($entity);
			$pdf->_show($entity);
		}
		return $pdf->Output('','S');
	}
	
	private function _init(Bill $entity)
	{
		$this->police = 'Times';
		$this->addPage('P');
		$this->setFillColor(200);
		$this->setXY(120,56);
		$this->setFont($this->police,'B',12);

		$this->cell(0,5,$entity->getTrusteeName(),0,2);
		$this->setFont($this->police,'',12);
		$this->multiCell(0,5,$entity->getTrusteeAddress());
		$this->ln(20);
		$this->setFont($this->police,'B',14);
		$this->cell(0,8,(($entity->getFirstBoost() === null) ? '1er' : '2ème').' RAPPEL',1,1,'C',1);
		$this->ln(6);
		$this->setFont($this->police,'',12);
		$this->setX(100);
		$date = new \DateTime;
		$mois = array(1=>'janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');
		$this->setFont($this->police,'',13);
		$this->cell(0,6,'Saint-Soupplets, le '.$date->format('j').' '.$mois[$date->format('n')].' '.$date->format('Y'),0,2,'R');
		$this->ln(12);
		
	}
	
	
	private function _show(Bill $entity)
	{
		$this->setFont($this->police,'',13);
		$this->cell(0,5,'Madame, Monsieur,',0,1);
		$this->ln(5);
		
		if ($entity->getFirstBoost() === null)
		{
			// Texte 1er Rappel
			$this->cell(0,5,'Nous nous permettons de vous signaler qu\'à ce jour nous n\'avons toujours pas enregistré le',0,1,'FJ');
			$this->cell(0,5,'règlement concernant la facture :',0,1);
			$this->ln(5);
			$this->setFont($this->police,'BU',13);
			$this->cell(0,5,'Affaire',0,1,'C');
			$this->setFont($this->police,'',13);
			$this->multiCell(0,5,$entity->getSite(),0,'C');
			$this->ln(2);
			$this->cell(0,5,'Facture n°'.$entity->getNumber().' du '.$entity->getCreation()->format('d/m/Y').' de '.number_format($entity->getTotalPriceAti(),2,',',' ').' €',0,1,'C');
			$this->ln(5);
			$this->cell(0,5,'Afin de régulariser cette situation, nous vous prions de bien vouloir nous faire parvenir votre',0,1,'FJ');
			$this->cell(0,5,'réglement par un prochain courrier.',0,1);
			$this->ln(5);
			$this->cell(0,5,'Dans le cas ou le réglement serait en cours, veuillez ne pas tenir compte de ce rappel.',0,1);
			$this->ln(5);
			$this->cell(0,5,'Nous vous prions de croire, Madame, Monsieur, à nos sentiment dévoués.',0,1);
		}
		else 
		{
			// Texte 2ème Rappel
			$this->cell(0,5,'Notre dernier courrier étant resté sans effet, nous vous signalons qu\'à ce jour, sauf erreur ou omission',0,1,'FJ');
			$this->cell(0,5,'de notre part, la facture ci-jointe pour un montant de '.number_format($entity->getTotalPriceAti(),2,',',' ').' € n\'est pas encore réglée.',0,1);
			$this->ln(5);
			$this->cell(0,5,'Nous vous remercions de bien vouloir régulariser votre situation dans les meilleurs délais.',0,1);
			$this->ln(5);
			$this->cell(0,5,'Comptant sur votre diligence, nous vous prions d\'agréer, Madame, Monsieur l\'expression de nos',0,1,'FJ');
			$this->cell(0,5,'salutations distinguées.',0,1);
		}
		$this->ln(20);
		$this->cell(0,5,'Service comptabilité',0,0,'R');
		if ($entity->getFirstBoost() !== null)
		{
			
		}
	}
	
	public function header()
	{
			$this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-header-comp.jpg',10,4,190);
	}
	
	public function footer()
	{
		$this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-footer.jpg',50,280,110);
	}
}