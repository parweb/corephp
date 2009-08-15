<?php
/**
 * Core PHP Framework
 * Copyright (C) 2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 *
 * This file is part of Core PHP Framework.
 *
 * Core PHP Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Core PHP Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Core PHP Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    Core
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version    0.1
 */

/**
 * Core class
 *
 * @package    Core
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 */
abstract class Core
{
    /**
     * Boot framework
     */
    public static function boot ()
    {
        Config::parseApplicationFiles ();
        self::loadVendorPlugins ();
        self::loadBootFiles ();
    }

    /**
     * Load application boot files
     */
    protected static function loadBootFiles ()
    {
        foreach ( new GlobIterator ( 'app/bootfiles/*.php', GlobIterator::CURRENT_AS_PATHNAME ) as $file )
        {
            require $file;
        }
    }

    /**
     * Load vendor plugins
     */
    protected static function loadVendorPlugins ()
    {
        foreach ( new GlobIterator ( 'vendor/plugins/*/init.php', GlobIterator::CURRENT_AS_PATHNAME ) as $file )
        {
            require $file;
        }
    }

    /**
     * Dispatch request
     *
     * @see Controller\Router::dispatch()
     */
    public static function dispatch ()
    {
        Controller\Router::dispatch ();
    }
}
