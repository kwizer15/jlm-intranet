<?php
/**
 * Created by PhpStorm.
 * User: kwizer
 * Date: 01/08/18
 * Time: 22:38
 */

namespace HM\Domain\ValueObject\Address\Street\Number;


use HM\Domain\ValueObject\Enum;

final class RepetitionIndicator extends Enum
{
    const NONE = '';
    const BIS = 'bis';
    const TER = 'ter';
    const QUATER = 'quater';
    const A = 'A';
    const B = 'B';
    const C = 'C';
    const D = 'D';
    const E = 'E';
    const F = 'F';
    const G = 'G';
    const H = 'H';
    const I = 'I';
    const J = 'J';
}