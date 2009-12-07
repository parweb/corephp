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
 * @subpackage Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

namespace Controller;

/**
 * Session class
 *
 * @package    Core
 * @subpackage Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class Session {
    /**
     * Initialize session data
     */
    public function __construct () {
        session_start();
    }

    /**
     * Write session data and end session
     */
    public function __destruct () {
        session_write_close();
    }

    /**
     * Retrive a variable from session
     *
     * @param string $name
     * @return mixed
     */
    public function __get ($name) {
        return $_SESSION[$name];
    }

    /**
     * Register a session variable
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set ($name, $value) {
        $_SESSION[$name] = $value;
    }

    /**
     * Verify if a session variable is registered
     *
     * @param string $name
     * @return boolean
     */
    public function __isset ($name) {
        return isset($_SESSION[$name]);
    }

    /**
     * Unregister a session variable
     *
     * @var string $name
     */
    public function __unset ($name) {
        unset($_SESSION[$name]);
    }
}

