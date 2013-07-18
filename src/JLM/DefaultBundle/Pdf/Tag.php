<?php
namespace JLM\DefaultBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class Tag extends FPDFext
{
	private $entity;

	public static function get($entities)
	{
		
		$pdf = new self();
		$pdf->_init();
		foreach ($entities as $entity)
			$pdf->addEntity($entity);
		return $pdf->Output('','S');
	}
	
	public function addEntity($entity)
	{
		$this->addPage();
		$id = $entity->getId();
		$url = 'http://chart.apis.google.com/chart?chs=180x180&choe=UTF-8&cht=qr&chl=http://www.jlm-entreprise.fr/installation/'.$id;
		$this->image($url,10,10,30,30,'png');
		$this->setFont('Arial','B',11);
		$this->cell(0,5,$entity->getId(),0,2);
		return $this;
	}
	
	public function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
	}
}