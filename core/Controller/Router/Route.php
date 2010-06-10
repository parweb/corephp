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
 * @category   Router
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.2
 */

namespace Controller\Router;

/**
 * Route class
 *
 * @package    Core
 * @subpackage Controller
 * @category   Router
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class Route {
    /**
     * Default options
     *
     * @var array
     */
    protected static $defaultOptions = array(
    	'controller' => 'home',
    	'action'     => 'index',
    	'format'     => 'html'
    );

    /**
     * URL
     *
     * @var string
     */
    protected $url;

    /**
     * Route options
     *
     * @var array
     */
    protected $options;

    /**
     * Compiled regex
     *
     * @var string
     */
    protected $regex;

    /**
     * Set $url and $options
     *
     * @param string $url
     * @param array $options
     */
    public function __construct ($url, array $options = array ()) {
        $this->url = $url;
        $this->options = array_merge(self::$defaultOptions, $options);
    }

    /**
     * Route match with $uri?
     *
     * @param string $uri
     * @return array or false
     */
    public function match ($uri) {
        if (preg_match($this->regex(), $uri, $options)) {
            return array_merge($this->options, $options);
        }

        return false;
    }

    /**
     * Get route regex
     */
    protected function regex () {
        if (!$this->regex) {
            $url = preg_replace('/\\\:([a-z\d_]+)/i', '(?<\1>[a-zA-Z\d_]+)', preg_quote($this->url, '/'));
            $this->regex = '/^' . $url . '$/';
        }

        return $this->regex;
    }
}