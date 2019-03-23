<?php

declare(strict_types=1);

namespace HM\Common\UI\Projection\InMemory;

use HM\Common\UI\Projection\AbstractProjection;
use HM\Common\UI\Projection\Projection;

abstract class AbstractInMemoryProjection extends AbstractProjection
{
    /**
     * @return Projection
     */
    final public function initialize(): Projection
    {
        return $this->reset();
    }

    /**
     * @return Projection
     */
    final public function delete(): Projection
    {
        return $this->reset();
    }
}
