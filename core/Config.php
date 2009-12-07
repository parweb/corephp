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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Core PHP Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    Core
 * @subpackage Config
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1a
 */

/**
 * Config class
 *
 * @package    Core
 * @subpackage Config
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
abstract class Config {
    /**
     * Loaded configs
     *
     * @var array
     */
    protected static $configs = array();

    /**
     * Parse application config files
     */
    public static function parseApplicationFiles () {
        foreach (new GlobIterator('app/config/*.ini', GlobIterator::CURRENT_AS_PATHNAME) as $file) {
            self::$configs = array_merge(self::$configs, parse_ini_file($file));
        }
    }

    /**
     * Get a config value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get ($key, $default = null) {
        return isset(self::$configs[$key]) ? self::$configs[$key] : $default;
    }

    /**
     * Set a config value
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set ($key, $value) {
        self::$configs[$key] = $value;
    }
}

