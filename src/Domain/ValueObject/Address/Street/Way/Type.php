<?php

namespace HM\Domain\ValueObject\Address\Street\Way;

use HM\Domain\ValueObject\Enum;

final class Type extends Enum
{
    const NONE = '';
    const AVENUE = 'avenue';
    const BOULEVARD = 'boulevard';
    const CHEMIN = 'chemin';
    const IMPASSE = 'impasse';
    const RUE = 'rue';
}