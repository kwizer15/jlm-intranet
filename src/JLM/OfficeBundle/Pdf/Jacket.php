<?php
namespace JLM\OfficeBundle\Pdf;

class Jacket extends \FPDF
{
	private $entity;
	
	public static function get(\JLM\OfficeBundle\Entity\Quote $entity)
	{
	
		$pdf = new self();
		$pdf->addPage();
		$pdf->setFont('Arial','B',14);
		$pdf->cell(0,7,utf8_decode($entity->getTrusteeName()),0,1);
		$pdf->setFont('Arial','I',14);
		$pdf->multicell(0,7,utf8_decode($entity->getTrusteeAddress()),0);
		$pdf->ln(5);
		$trustee = $entity->getTrustee();
		if ($trustee)
		{
			$pdf->setFont('Arial','',14);
			if ($trustee->getPhone())
				$pdf->cell(0,7,utf8_decode('Tèl : '.$trustee->getPhone()),0,1);
			if ($trustee->getFax())
				$pdf->cell(0,7,utf8_decode('Fax : '.$trustee->getFax()),0,1);
			$pdf->ln(5);
		}
		$pdf->setFont('Arial','BI',11);
		$pdf->cell(0,6,utf8_decode($entity->getContactCp()),0,1);
		$contact = null;
		if ($entity->getContact())
			$contact = $entity->getContact()->getPerson();
		if ($contact)
		{
			$pdf->setFont('Arial','I',11);
			if ($contact->getMobilePhone())
				$pdf->cell(0,5,utf8_decode('Tél port. : '.$contact->getMobilePhone()),0,1);
			if ($contact->getFixedPhone())
				$pdf->cell(0,5,utf8_decode('Tél fixe : '.$contact->getFixedPhone()),0,1);
			if ($contact->getFax())
				$pdf->cell(0,5,utf8_decode('Fax : '.$contact->getFax()),0,1);
			if ($contact->getEmail())
				$pdf->cell(0,5,utf8_decode('Email : '.$contact->getEmail()),0,1);
		}
		$pdf->setXY(100,230);
		$pdf->setFont('Arial','B',14);
		$pdf->multicell(0,7,utf8_decode($entity->getDoorCp()),0);
		return $pdf->Output('','S');
	}
}