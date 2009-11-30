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
 * Controller router class
 *
 * @package    Core
 * @subpackage Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
abstract class Router {
    /**
     * Connected routes
     *
     * @var array
     */
    protected static $routes = array();

    /**
     * Connect a route
     *
     * @param string $url
     * @param array $options
     */
    public static function connect ($url, array $options = array ()) {
        $url = trim($url, '/');
        self::$routes[$url] = new Router\Route($url, $options);
    }

    /**
     * Disconnect a route
     *
     * @param string $url
     */
    public static function disconnect ($url) {
        unset(self::$routes[$url]);
    }

    /**
     * Dispatch request
     */
    public static function dispatch () {
        $uri = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : '';
        $options = null;

        foreach (self::$routes as $route) {
            if ($options = $route->match($uri)) {
                break;
            }
        }

        if (!$options) {
            throw new Router\Exception('No route matches');
        }

        foreach ($options as $param => $value) {
            $_REQUEST[$param] = $value;
        }

        \Controller::dispatch($options['controller'], $options['action']);
    }
}

