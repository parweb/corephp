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
 * @subpackage Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version    0.1
 */

/**
 * Controller class
 *
 * @package    Core
 * @subpackage Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 */
abstract class Controller {
    /**
     * Layout
     *
     * @var string
     */
    protected $layout = null;

    /**
     * Factory the controller
     *
     * @param string $controller controller name without 'Controller' at the end
     * @return Controller
     * @throws Controller\Exception when controller not found
     * @throws Controller\Exception when $controller is not a controller
     */
    public static function factory ($controller) {
        $controller = Inflector::camelize($controller) . 'Controller';

        if (!class_exists($controller)) {
            throw new Controller\Exception("Controller `$controller' not found");
        }

        if (!is_subclass_of($controller, __CLASS__) || $controller == 'ApplicationController') {
            throw new Controller\Exception("Controller `$controller' is not a controller");
        }

        return new $controller;
    }

    /**
     * Dispatch a controller action
     *
     * @param string $controller
     * @param string $action
     * @throws Controller\Exception when action not found
     * @throws Controller\Exception when action is not public
     */
    public static function dispatch ($controller, $action) {
        // Dispatch action to controller
        $kontroller = self::factory($controller);
        $action = Inflector::camelize($action, true);
        $reflection = new ReflectionClass($kontroller);

        if (!$reflection->hasMethod($action)) {
            throw new Controller\Exception("Action `$action' not found");
        }

        if (!$reflection->getMethod($action)->isPublic()) {
            throw new Controller\Exception("Action `$action' is not public");
        }

        // Create a reference to controller into view
        // TODO: This should be into a before_filter callback
        View::set('controller', $kontroller);

        // Return if not to render
        if ($kontroller->$action() === false || View::wasRendered()) {
            return;
        }

        // Set public vars of controller
        // TODO: This should be into a after_filter callback
        View::set($kontroller);

        // Render the template
        // TODO: This should be into a after_filter callback
        echo View::render("$controller/$action", $kontroller->layout);
    }
}

