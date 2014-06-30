<?php

/*
 * This file is part of the  package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class Document extends FPDFext
{
    protected $entity;
    protected $end = false;
    protected $head = true;
    protected $variantpage = 0;
    protected $colsize;
    
    public static function get($entities, $options = false)
    {
    
        $pdf = new static();
        $pdf->_init();
        foreach ($entities as $entity)
        {
            $pdf->addEntity($entity, $options);
        }
        
        return $pdf->Output('','S');
    }
    
    public function addEntity($entity, $options)
    {
        $this->entity = $entity;
        $this->variantpage = $this->pageNo() + 1;
        $this->addPage();
        $this->_header($options);
        $this->_content();
        $this->_footer();
        
        return $this;
    }
    
    public function _init()
    {
        $this->aliasNbPages();
        $this->setFillColor(200);
        $this->colsize = $this->getColsize();
    }
    
    public function _content()
    {
        // En tête lignes
        $this->tabHeader();
        $this->setFont('Arial','',10);
        $lines = $this->entity->getLines();
        foreach ($lines as $line)
        {
            $this->_line($line);
        }
    }
    
    public function header()
    {
        if ($this->pageNo() == $this->variantpage )
        {
            $this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-header-comp.jpg',10,4,190);
            $this->setFont('Arial','B',24);
            $this->cell(60,35,strtoupper($this->getDocumentName()),0,1,'C');
            $this->ln(5);
        }
        else
        {
            	
            // Création
            $this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-logo-comp.jpg',90,4,30);
            $this->setFont('Arial','B',20);
            $this->cell(60,12,strtoupper($this->getDocumentName()),0,0,'L');
            $this->cell(89,6);
            $this->setFont('Arial','B',10);
            $this->cell(22,6,'Date','LRT',0,'C',true);
            $this->cell(19,6,$this->getDocumentName().' n°','LRT',1,'C',true);
            $this->setFont('Arial','',10);
            $this->cell(149,6);
            $this->cell(22,6,$this->entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
            $this->cell(19,6,$this->entity->getNumber(),'LRB',1,'C');
            $this->ln(6);
            $this->tabHeader();
            $this->setFont('Arial','',10);
        }
    }
    
    public function footer()
    {
        $this->ln(0);
        if (!$this->end)
        {
            $y = $this->getY();
            $h = 278 - $y;
            $nb = sizeof($this->colsize) - 1;
            foreach ($this->colsize as $key => $size)
            {
                $this->cell($this->colsize[0],$h,'','RLB',($key == $nb));
            }
        }
    
        $this->image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-footer.jpg',50,280,110);
        $this->setY(-15);
        // Police Arial italique 8
        $this->setFont('Arial','',12);
        // Numéro de page
        $this->cell(0,10,$this->PageNo().'/{nb}',0,0,'R');
    }
    
    abstract public function getDocumentName();
    abstract protected function getColsize();
    abstract public function _header($options);
    abstract public function tabHeader();
    abstract public function _line($line);
    abstract public function _footer();
}