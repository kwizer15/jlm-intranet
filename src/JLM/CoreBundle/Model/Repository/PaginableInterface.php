<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Model\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface PaginableInterface
{
    /**
     * Get entity list paginated
     * @param int $page
     * @param int $resultsByPage
     * @param array $filters
     * @return Paginator
     */
    public function getPaginable($page, $resultsByPage, array $filters);
}
