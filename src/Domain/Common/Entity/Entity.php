<?php

namespace HM\Domain\Common\Entity;

use HM\Domain\Common\Identities\Identity;

interface Entity
{
    /**
     * @return Identity
     */
    public function id(): Identity;
}
