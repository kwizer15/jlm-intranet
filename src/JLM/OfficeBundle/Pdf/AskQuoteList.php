<?php

namespace JLM\OfficeBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;
use \JLM\OfficeBundle\Entity\AskQuote;

class AskQuoteList extends FPDFext
{
    public static function get($entities)
    {

        $pdf = new self();
        $pdf->init();
        $pdf->customHeader();
        foreach ($entities as $entity) {
            $pdf->customLine($entity);
        }
        return $pdf->Output('', 'S');
    }

    public function init()
    {
        $this->aliasNbPages();
        $this->setFillColor(200);
        $this->addPage('L');
    }

    public function customHeader()
    {
        $this->setFont('Arial', 'B', 18);
        $this->multicell(0, 12, 'Liste des devis à faire', 1, 1, 'C', true);
        $this->ln(5);
        $this->setFont('Arial', 'B', 11);
        $this->setWidths([24, 34, 63, 8, 79, 69]); // -29
        $this->row(['Date', 'Syndic', 'Affaire', 'Ctr', 'Demande', 'Notes'], 6, 1, true);
        $this->setFont('Arial', '', 10);
    }

    private function customLine(AskQuote $entity)
    {
        $types = [
            'fixing' => 'Dépannage',
            'maintenance' => 'Entretien',
            'work' => 'Travaux',
        ];
        $datas[0] = $entity->getCreation()->format('d/m/Y');
        $datas[1] = $entity->getTrustee() . '';
        $datas[2] = '';
        $datas[3] = '';
        if ($entity->getDoor() !== null) {
            $datas[2] .= $entity->getDoor()->getType() . ' - ' . $entity->getDoor()->getLocation() . chr(10);
            $datas[3] .= ($entity->getDoor()->getContract() == 'Hors contrat') ? 'HC' : $entity->getDoor()
                ->getActualContract()
            ;
        }
        if ($entity->getSite() !== null) {
            $datas[2] .= $entity->getSite()->getAddress()->toString();
        }
        $datas[4] = 'Suite à ';
        $datas[4] .= ($entity->getIntervention() !== null) ? $types[$entity->getIntervention()->getType()] : 'demande';
        $datas[4] .= chr(10) . $entity->getAsk();
        $datas[5] = '';
        $this->row($datas, 5, 1, false);
    }
}
