<?php

declare(strict_types=1);

namespace HM\Common\UI\Query;

use HM\Common\Domain\ViewModel\ViewModel;

interface QueryHandler
{
    public function handle(Query $query): ViewModel;
}
