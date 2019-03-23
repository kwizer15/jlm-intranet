<?php

declare(strict_types=1);

namespace HM\Common\UI\Query;

interface QueryHandler
{
    public function handle(Query $query): ViewModel;
}
