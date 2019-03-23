<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\ValueType;

use HM\Common\Domain\ValueType\ValueType;
use HM\Facturation\Domain\ValueType\ReglesPaiement\Echeance;
use HM\Facturation\Domain\ValueType\ReglesPaiement\Escompte;
use HM\Facturation\Domain\ValueType\ReglesPaiement\PenaliteRetard;

final class ReglesPaiement implements ValueType
{
    /**
     * @var Echeance
     */
    private $echeance;

    /**
     * @var Escompte
     */
    private $escompte;

    /**
     * @var PenaliteRetard
     */
    private $penaliteRetard;

    /**
     * @param Echeance $echeance
     * @param Escompte $escompte
     * @param PenaliteRetard $penaliteRetard
     */
    private function __construct(Echeance $echeance, Escompte $escompte, PenaliteRetard $penaliteRetard)
    {
        $this->echeance = $echeance;
        $this->escompte = $escompte;
        $this->penaliteRetard = $penaliteRetard;
    }

    /**
     * @param Echeance $echeance
     * @param Escompte $escompte
     * @param PenaliteRetard $penaliteRetard
     *
     * @return ReglesPaiement
     */
    public static function withRegles(Echeance $echeance, Escompte $escompte, PenaliteRetard $penaliteRetard): ReglesPaiement
    {
        return new self($echeance, $escompte, $penaliteRetard);
    }

    /**
     * @return Echeance
     */
    public function getEcheance(): Echeance
    {
        return $this->echeance;
    }

    /**
     * @return Escompte
     */
    public function getEscompte(): Escompte
    {
        return $this->escompte;
    }

    /**
     * @return PenaliteRetard
     */
    public function getPenaliteRetard(): PenaliteRetard
    {
        return $this->penaliteRetard;
    }
}
