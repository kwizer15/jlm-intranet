<?php

declare(strict_types=1);

namespace HM\Facturation\Domain\Facture\Destinataire;

use HM\Common\Domain\Exception\DomainException;
use HM\Common\Domain\ValueType\ValueType;

final class AdressePostale implements ValueType
{
    /**
     * @var string
     */
    private $rue;

    /**
     * @var string
     */
    private $codePostal;

    /**
     * @var string
     */
    private $ville;

    /**
     * @param string $rue
     * @param string $codePostal
     * @param string $ville
     *
     * @return AdressePostale
     */
    public static function fromStrings(string $rue, string $codePostal, string $ville): AdressePostale
    {
        return new self($rue, $codePostal, $ville);
    }

    /**
     * @return string
     */
    public function getRue(): string
    {
        return $this->rue;
    }

    /**
     * @return string
     */
    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    /**
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * @param string $rue
     * @param string $codePostal
     * @param string $ville
     */
    private function __construct(string $rue, string $codePostal, string $ville)
    {
        self::validate($rue, $codePostal, $ville);
        $this->rue = $rue;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
    }

    /**
     * @param string $rue
     * @param string $codePostal
     * @param string $ville
     */
    private static function validate(string $rue, string $codePostal, string $ville): void
    {
        if (!preg_match('/^[0-9A-ZÉÈÎÀÊÔÇa-zéèàîêôçù& \-]+$/u', $rue)) {
            throw new DomainException(sprintf('%s est un nom de ville incorrect.', $rue));
        }

        if (!preg_match('/^(2[AB1-9]|[0-13-8]\d|9([1-5]|7))\d{3}$/', $codePostal)) {
            throw new DomainException(sprintf('%s est un code postal invalide', $codePostal));
        }

        if (!preg_match('/^[A-ZÉÈÎÀÊÔÇa-zéèàîêôçù& \-]+$/u', $ville)) {
            throw new DomainException(sprintf('%s est un nom de ville incorrect.', $ville));
        }
    }
}
