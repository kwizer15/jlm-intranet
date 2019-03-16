<?php

namespace JLM\OfficeBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;
use Symfony\Component\Validator\Constraints\DateTime;

class Order extends FPDFext
{

    private $entity;

    public static function get($entity)
    {
        $pdf = new self();
        $pdf->setEntity($entity[0]);
        $pdf->addPage();
        $pdf->init();
        $pdf->customHeader();
        $pdf->content();
        return $pdf->Output('', 'S');
    }

    public function setEntity(\JLM\OfficeBundle\Entity\Order $entity)
    {
        $this->entity = $entity;
        return $this;
    }

    public function init()
    {
        $this->aliasNbPages();
        $this->setFillColor(200);
    }

    public function customHeader()
    {
        $date = new \DateTime();
        $this->setFont('Arial', 'B', 16);
        $this->cell(0, 8, 'Référence', 0, 1);
        $this->setFont('Arial', '', 16);
        $this->multicell(0, 8, $this->entity->getWork()->getPlace(), 0);
        $this->cell(0, 8, 'Code : ' . $this->entity->getWork()->getDoor()->getCode(), 0);
        $this->cell(0, 8, 'Imprimé le ' . $date->format('d/m/Y'), 0, 1, 'R');
        $quote = $this->entity->getWork()->getQuote();
        if ($quote === null) {
            $this->cell(0, 8, 'Complet', 0, 1, 'R');
        } else {
            $this->cell(0, 8, 'Devis n°' . $quote->getNumber(), 0, 1, 'R');
        }

        if ($this->entity->getTime() > 0) {
            $this->cell(0, 8, 'Temps prévu (heure/technicien) : ' . $this->entity->getTime(), 0, 1, 'R');
        }
        $this->ln(12);
    }

    public function content()
    {
        $this->setFont('Arial', 'B', 16);
        $this->cell(0, 8, 'Désignations', 0, 1);
        $this->setFont('Arial', '', 16);
        $this->ln(5);
        $nbl = 13;
        $lines = $this->entity->getLines();
        foreach ($lines as $line) {
            $this->cell(10, 8, $line->getQuantity(), 'B', 0);
            $this->cell(170, 8, $line->getDesignation(), 'B', 0);
            $this->cell(10, 8, '', 1, 1);
            $this->ln(5);
            $nbl--;
        }
        for ($i = 0; $i < $nbl; $i++) {
            $this->cell(180, 8, '', 'B', 0);
            $this->cell(10, 8, '', 1, 1);
            $this->ln(5);
        }
    }
}
