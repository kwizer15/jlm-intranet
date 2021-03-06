<?php

/*
 * This file is part of the  package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Pdf;

use JLM\DefaultBundle\Pdf\FPDFext;
use JLM\DailyBundle\Entity\Intervention;

class BillList extends FPDFext
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
        $this->multicell(0, 12, 'Liste des interventions à facturer', 1, 1, 'C', true);
        $this->ln(5);
        $this->setFont('Arial', 'B', 11);
        $this->setWidths([24, 30, 58, 24, 8, 64, 69]); // -29
        $this->row(['Date', 'Syndic', 'Affaire', 'Type', 'Ctr', 'Raison', 'Rapport'], 6, 1, true);
        $this->setFont('Arial', '', 10);
    }
    
    private function customLine(Intervention $entity)
    {
        $types = [
                  'fixing'      => 'Dépannage',
                  'maintenance' => 'Entretien',
                  'work'        => 'Travaux',
                 ];
        $dayTrans = [
                     'dimanche',
                     'lundi',
                     'mardi',
                     'mercredi',
                     'jeudi',
                     'vendredi',
                     'samedi',
                    ];
        $datas[0] = $dayTrans[$entity->getClose()->format('w')].chr(10).$entity->getClose()->format('d/m/Y');
        $datas[1] = $entity->getDoor()->getTrustee();
        $datas[2] = $entity->getDoor()->getSite()->getAddress().'';
        $datas[3] = $types[$entity->getType()];
        $datas[4] = ($entity->getContract() == 'Hors contrat') ? 'HC' : $entity->getDynContract();
        $datas[5] = $entity->getReason();
        $datas[6] = 'Rapport :'.chr(10).$entity->getReport();
        if ($entity->getRest()) {
            $datas[6] .= chr(10).chr(10).'Reste à faire :'.chr(10).$entity->getRest();
        }
        $this->row($datas, 5, 1, false);
    }
}
