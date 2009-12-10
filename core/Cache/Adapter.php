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

namespace Cache;

/**
 * Adapter class
 *
 * @package    Core
 * @subpackage Cache
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
interface Adapter {
    /**
     * Retrieve item from the server
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get ($key);

    /**
     * Store data at the server
     *
     * @param string $key
     * @param mixed $value
     * @param integer $ttl
     * @return boolean true on success or false otherwise
     */
    public function set ($key, $value, $ttl);

    /**
     * Delete item from the server
     *
     * @param string $key
     * @return boolean true on success or false otherwise
     */
    public function delete ($key);

    /**
     * Flush all existing items at the server
     *
     * @return boolean true on success or false otherwise
     */
    public function flush ();
}

