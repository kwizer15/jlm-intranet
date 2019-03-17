<?php

namespace HM\Domain\Facturation\ValueType;

use HM\Domain\Common\ValueType\ValueType;

final class ReglesPaiment implements ValueType
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
     * @return ReglesPaiment
     */
    public static function withRegles(Echeance $echeance, Escompte $escompte, PenaliteRetard $penaliteRetard): ReglesPaiment
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
