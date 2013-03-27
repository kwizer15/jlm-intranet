<?php

namespace JLM\OfficeBundle\Pdf;
use JLM\OfficeBundle\Entity\Task;

class TaskList extends \FPDF
{
	private $entities;

	public static function get($entities)
	{

		$pdf = new self();
		$pdf->_init();
		$pdf->addPage();

	//	var_dump($entities); exit;
		foreach ($entities as $entity)
			$pdf->_line($entity);
		return $pdf->Output('','S');
	}
	
	public function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
	}
	
	public function header()
	{
		$this->setFont('Arial','B',11);
		$this->cell(25,6,utf8_decode('Date'),1,0,'L',1);
		$this->cell(60,6,utf8_decode('Affaire'),1,0,'L',1);
		$this->cell(75,6,utf8_decode('Détails'),1,0,'L',1);
		$this->cell(30,6,utf8_decode('Notes'),1,1,'L',1);
	}
	
	public function _line(Task $entity)
	{
		$this->setFont('Arial','',11);
		$h = 0;
		$y = $this->getY();
		$nbl = substr_count($entity->getPlace(),chr(10));
		$nbl2 = substr_count($entity->getTodo(),chr(10));
		$n = ($nbl > $nbl2) ? $nbl : $nbl2;
		$n *= 5;
		if ($y > (270-$n))
		{
			$this->addPage();
			$y = $this->getY();
		}
		$x = $this->getX();
		$this->multicell(25,5,utf8_decode($entity->getOpen()->format('d/m/Y').chr(10).$entity->getType()),0);
		$h = ($h < $this->getY() - $y) ? $this->getY() - $y : $h;
		$this->setXY($x+25,$y);
		$this->setFont('Arial','I',11);
		$this->multicell(60,5,utf8_decode($entity->getPlace()),0);
		$h = ($h < $this->getY() - $y) ? $this->getY() - $y : $h;
		$this->setXY($x+85,$y);
		$this->setFont('Arial','',11);
		$this->multicell(75,5,utf8_decode($entity->getTodo()),0);
		$h = ($h < $this->getY() - $y) ? $this->getY() - $y : $h;
		$this->setXY($x,$y);
		$h += 3;
		$this->cell(25,$h,'',1);
		$this->setXY($x+25,$y);
		$this->cell(60,$h,'',1);
		$this->setXY($x+85,$y);
		$this->cell(75,$h,'',1);
		$this->setXY($x+160,$y);
		$this->cell(30,$h,'',1,1);
	}
}