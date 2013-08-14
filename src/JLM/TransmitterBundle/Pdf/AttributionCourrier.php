<?php
namespace JLM\TransmitterBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class AttributionCourrier extends FPDFext
{
	private $police;
	
	public static function get($entity)
	{
		$pdf = new self();
		$pdf->_init($entity);
		$pdf->_show($entity);
		return $pdf->Output('','S');
	}
	
	private function _init($entity)
	{
		$this->police = 'Times';
		$this->addPage('P');
		$this->setXY(100,60);
		$this->setFont($this->police,'B',12);
		if ($entity->getIndividual())
		{
			$this->cell(0,5,$entity->getContact(),0,2);
			$this->setFont($this->police,'',12);
			$this->multiCell(0,5,$entity->getSite()->toString());
		}
		else
		{
			$this->cell(0,5,$entity->getAsk()->getTrustee(),0,2);
			$this->setFont($this->police,'',12);
			$this->multiCell(0,5,$entity->getAsk()->getTrustee()->getAddress()->toString());
			if ($entity->getContact() != null)
			{
				$this->ln(5);
				$this->setX(100);
				$this->cell(0,6,'A l\'attention de '.$entity->getContact(),0,2);
			}
		}
		
		$this->ln(5);
		$this->setFont($this->police,'BU',12);
		$this->cell(0,6,'Affaire',0,2);
		$this->setFont($this->police,'',12);
		$this->multiCell(100,6,$entity->getSite()->toString(),0);
		$this->ln(6);
		$this->setX(100);
		$date = $entity->getCreation();
		$mois = array(1=>'janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');
		$this->setFont($this->police,'',10);
		$this->cell(0,6,'Saint-Soupplets, le '.$date->format('j').' '.$mois[$date->format('n')].' '.$date->format('Y'),0,2);
		$this->ln(12);
		
	}
	
	
	private function _show($entity)
	{
		$this->setFont($this->police,'',13);
		$this->cell(0,5,'Madame, Monsieur,',0,1);
		$this->ln(5);
		$this->cell(0,5,'Veuillez trouver ci-joint les émetteurs commandés pour l\'affaire référencée ci-dessus,',0,1,'FJ');
		$this->cell(0,5,'accompagnés d\'une liste d\'attribution d\'émetteurs à remplir et à garder précieusement. Celle-ci',0,1,'FJ');
		$this->cell(53,5,'est nécessaire en cas de ',0,0,'FJ');
		$this->setFont($this->police,'BU',13);
		$this->cell(12,5,'perte',0,0);
		$this->setFont($this->police,'',13);
		$this->cell(19,5,' ou de ',0,0,'FJ');
		$this->setFont($this->police,'BU',13);
		$this->cell(7,5,'vol',0,0);
		$this->setFont($this->police,'',13);
		$this->cell(0,5,' d\'un émetteur. Sur cette liste vous répertoriez les',0,1,'FJ');
		$this->cell(0,5,'personnes à qui vous attribuez les émetteurs.',0,1);
		$this->ln(5);
		$this->cell(0,5,'Nous restons à votre disposition pour tous renseignements complémentaires.',0,1);
		$this->ln(5);
		$this->cell(0,5,'Nous vos souhaitons bonne réception et vous prions d\'agréer, Madame, Monsieur,',0,1,'FJ');
		$this->cell(0,5,'l\'expression de nos salutations distinguées.',0,1);
		$this->ln(20);
		$this->cell(0,5,'Service secrétariat',0,0,'R');
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