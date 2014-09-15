<?php

/*
 * This file is part of the  package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */

if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])) {
    passthru(sprintf(
    'php "%s/console" cache:clear --env=%s --no-warmup',
    __DIR__,
    $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV']
    ));
}

require __DIR__.'/bootstrap.php.cache';