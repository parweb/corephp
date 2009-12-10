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
 * @subpackage Cache
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

/**
 * Cache class
 *
 * @package    Core
 * @subpackage Cache
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
abstract class Cache {
    /**
     * Cache adapter
     *
     * @var Cache\Adapter
     */
    protected static $adapter;

    /**
     * Factory cache adapter
     *
     * @return Cache\Adapter
     * @throws Cache\Exception when adapter not found or isn't a valid cache adapter
     */
    public static function getAdapter () {
        if (!self::$adapter instanceof Cache\Adapter) {
            $adapter = 'Cache\Adapters\\' . Inflector::camelize(Config::get('cache.adapter', 'file'));

            if (!class_exists($adapter) || !in_array('Cache\Adapter', class_implements($adapter))) {
                throw new Cache\Exception("Cache adapter `$adapter' not found or isn't a valid cache adapter");
            }

            self::$adapter = new $adapter;
        }

        return self::$adapter;
    }

    /**
     * Retrieve item from the server
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get ($key, $default = null) {
        return self::getAdapter()->get($key);
    }

    /**
     * Store data at the server
     *
     * @param string $key
     * @param mixed $value
     * @param integer $ttl
     * @return boolean true on success or false otherwise
     */
    public static function set ($key, $value, $ttl = 0) {
        return self::getAdapter()->set($key, $value, $ttl);
    }

    /**
     * Delete item from the server
     *
     * @param string $key
     * @return boolean true on success or false otherwise
     */
    public static function delete ($key) {
        return self::getAdapter()->delete($key);
    }

    /**
     * Flush all existing items at the server
     *
     * @return boolean true on success or false otherwise
     */
    public static function flush () {
        return self::getAdapter()->flush();
    }
}

