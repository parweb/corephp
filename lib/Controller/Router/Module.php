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
 * @version    0.1
 */

namespace Controller\Router;

/**
 * Module class
 *
 * @package    Core
 * @subpackage Controller
 * @category   Router
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class Module {
    /**
     * Module name
     *
     * @var string
     */
    protected $module;

    /**
     * Closure to configure route
     *
     * @var Closure
     */
    protected $closure;

    /**
     * Configured routes
     *
     * @var array
     */
    protected $routes;

    /**
     * Initialize the module
     *
     * @param string $module
     * @param Closure $closure
     */
    public function __construct ($module, \Closure $closure) {
        $this->module = $module;
        $this->closure = $closure;
    }

    /**
     * Route match with $uri?
     *
     * @param string $uri
     * @return array or false
     */
    public function match ($uri) {
        $options = null;

        foreach ($this->makeRoutes() as $route) {
            if ($options = $route->match($uri)) {
                break;
            }
        }

        if ($options && $route instanceof Route) {
            $options['controller'] = "$this->module/$options[controller]";
        }

        return $options;
    }

    /**
     * Connect a module route
     *
     * @param string $url
     * @param array $options
     */
    public function connect ($url, array $options = array()) {
        $url = rtrim("$this->module/$url", '/');
        $this->routes[$url] = new Route($url, $options);
    }

    /**
     * Connect a submodule
     *
     * @param string $submodule
     * @param Closure $closure
     */
    public function submodule ($submodule, \Closure $closure) {
        $submodule = "$this->module/$submodule";
        $this->routes[$submodule] = new self($submodule, $closure);
    }

    /**
     * Make routes
     */
    protected function makeRoutes () {
        if (empty($this->routes)) {
            $this->closure->__invoke($this);
        }

        return $this->routes;
    }
}

