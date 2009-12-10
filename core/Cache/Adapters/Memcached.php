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
 * @category   Adapters
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

namespace Cache\Adapters;

/**
 * Memcached adapter class
 *
 * @package    Core
 * @subpackage Cache
 * @category   Adapters
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class Memcached implements \Cache\Adapter {
    /**
     * Memcached instance
     *
     * @var \Memcache
     */
    protected $memcached;

    /**
     * Default server
     *
     * @var string
     */
    protected static $defaultServer = '127.0.0.1:11211';

    /**
     * Verify Memcached support
     *
     * @throws \Cache\Exception when Memcached isn't loaded
     * @throws \Cache\Exception when server format
     */
    public function __construct () {
        if (!extension_loaded('memcached')) {
            throw new \Cache\Exception("Could not find extension Memcached");
        }

        $this->memcached = new \Memcached;

        // TODO: can specify more than a once server with weight
        if (!preg_match('/^(?<host>[^:]+):(?<port>\d+)$/', \Config::get('cache.server', '127.0.0.1:11211'), $server)) {
            throw new \Cache\Exception('You must specify Memcached server with port, ie: 127.0.0.1:11211');
        }

        $this->memcached->addServer($server['host'], $server['port']);
    }

    /**
     * (non-PHPdoc)
     * @see \Cache\Adapter::get()
     */
    public function get ($key) {
        return $this->memcached->get($key);
    }

    /**
     * (non-PHPdoc)
     * @see \Cache\Adapter::set()
     */
    public function set ($key, $value, $ttl = 0) {
        return $this->memcached->set($key, $value, $ttl);
    }

    /**
     * (non-PHPdoc)
     * @see \Cache\Adapter::delete()
     */
    public function delete ($key) {
        return $this->memcached->delete($key);
    }

    /**
     * (non-PHPdoc)
     * @see \Cache\Adapter::flush()
     */
    public function flush () {
        return $this->memcached->flush();
    }
}

