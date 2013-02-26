<?php

namespace JLM\OfficeBundle\Pdf;

class Order extends \FPDF
{
	private $entity;
	
	public static function get($entity)
	{
		$pdf = new self();
		$pdf->setEntity($entity[0]);
		$pdf->addPage();
		$pdf->_init();
		$pdf->_header();
		$pdf->_content();
		return $pdf->Output('','S');
	}
	
	public function setEntity(\JLM\OfficeBundle\Entity\Order $entity)
	{
		$this->entity = $entity;
		return $this;
	}
	
	public function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
	}
	
	public function _header()
	{
		$this->setFont('Arial','B',16);
		$this->cell(0,8,utf8_decode('Référence'),0,1);
		$this->setFont('Arial','',16);
		$this->multicell(0,8,utf8_decode($this->entity->getPlace()),0);
		$this->ln(12);
	}
	
	public function _content()
	{
		$this->setFont('Arial','B',16);
		$this->cell(0,8,utf8_decode('Désignations'),0,1);
		$this->setFont('Arial','',16);
		$this->ln(5);
		$nbl = 13;
		$lines = $this->entity->getLines();
		foreach ($lines as $line)
		{
			$this->cell(10,8,utf8_decode($line->getQuantity()),'B',0);
			$this->cell(170,8,utf8_decode($line->getDesignation()),'B',0);
			$this->cell(10,8,'',1,1);
			$this->ln(5);
			$nbl--;
		}
		for ($i = 0; $i < $nbl; $i++)
		{
			$this->cell(180,8,'','B',0);
			$this->cell(10,8,'',1,1);
			$this->ln(5);
		}
	}
}