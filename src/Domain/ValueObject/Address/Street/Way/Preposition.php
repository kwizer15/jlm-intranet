<?php

namespace HM\Domain\ValueObject\Address\Street\Way;

use HM\Domain\ValueObject\Enum;

final class Preposition extends Enum
{
    const NONE = '';
    const DE = 'de';
    const DE_LA = 'de la';
    const DU = 'du';
}