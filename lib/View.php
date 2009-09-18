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
 * @subpackage View
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version    0.1
 */

/**
 * View class
 *
 * @package    Core
 * @subpackage View
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 */
abstract class View  {
    /**
     * View vars
     *
     * @var array
     */
    protected static $vars = array();

    /**
     * Was rendered?
     *
     * @var boolean
     */
    protected static $wasRendered = false;

    /**
     * Set a view var
     *
     * @param mixed $key
     * @param mixed $value
     */
    public static function set ($key, $value = null) {
        if (is_array($key) || is_object($key)) {
            self::$vars = array_merge(self::$vars, (array) $key);
        } else {
            self::$vars[$key] = $value;
        }
    }

    /**
     * Get a view var
     *
     * @param mixed $key
     * @return mixed
     */
    public static function get ($key) {
        return isset(self::$vars[$key]) ? self::$vars[$key] : null;
    }

    /**
     * Render the template and layout
     *
     * @param string $__template
     * @param string $__layout
     * @return string
     */
    public static function render ($__template, $__layout = null) {
        // Once render per request
        // TODO: If devel call render more than once time, it will be a partial
        if (self::wasRendered()) {
            throw new View\Exception('Only once render per request');
        }

        self::$wasRendered = true;

        // Parse file paths
        // TODO: Support another extensions for differents renders like HAML
        // TODO: Support another renders engines
        $__template = 'app/views/' . Inflector::underscore($__template) . '.phtml';

        if (!file_exists($__template)) {
            throw new View\Exception("Template `$__template' not found");
        }

        if ($__layout) {
            $__layout = 'app/views/layouts/' . Inflector::underscore($__layout) . '.phtml';

            if (!file_exists($__layout)) {
                throw new View\Exception("Layout `$__layout' not found");
            }
        }

        // Render template
        extract(self::$vars, EXTR_SKIP);
        ob_start();

        require $__template;
        $yield = ob_get_clean();

        // Render layout if have
        if ($__layout) {
            ob_start();

            require $__layout;
            $yield = ob_get_clean();
        }

        return $yield;
    }

    /**
     * Was rendered?
     *
     * @return boolean
     */
    public static function wasRendered () {
        return self::$wasRendered;
    }
}

