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

/**
 * Controller class
 *
 * @package    Core
 * @subpackage Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
abstract class Controller {
    /**
     * Layout
     *
     * @var string
     */
    protected $layout = null;

    /**
     * Performed?
     *
     * @var boolean
     */
    private $performed = false;

    /**
     * Lazy load request and session
     *
     * @param string $name
     * @return Controller\Request or Controller\Session
     */
    public function __get ($name) {
        switch ($name) {
            case 'request':
                return $this->request = new Controller\Request;

            case 'session':
                return $this->session = new Controller\Session;

            default:
                trigger_error(sprintf('Undefined property: %s::$%s', get_class($this), $name));
        }
    }

    /**
     * Factory the controller
     *
     * @param string $controller controller name without 'Controller' at the end
     * @return Controller
     * @throws Controller\Exception when $controller not found
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
        $kontroller = self::factory($controller);
        $action     = Inflector::camelize($action, true);
        $reflection = new ReflectionClass($kontroller);

        if (!$reflection->hasMethod($action)) {
            throw new Controller\Exception("Action `$action' not found");
        }

        if (!$reflection->getMethod($action)->isPublic()) {
            throw new Controller\Exception("Action `$action' is not public");
        }

        $kontroller->beforeAction();

        if ($kontroller->$action() !== false && !$kontroller->performed) {
            $kontroller->render();
        }

        $kontroller->afterAction();

        return $kontroller;
    }

    /**
     * Method called before action
     */
    protected function beforeAction () {
    }

    /**
     * Method called after action
     */
    protected function afterAction () {
    }

    /**
     * Render template
     *
     * @param string $template
     * @param string $layout
     */
    protected function render ($template = null, $layout = null) {
        $this->perform();

        if (!$template) {
            $template = param('controller') . '/' . param('action');
        } else if (strpos('/', $template) === false) {
            $template = param('controller') . '/' . $template;
        }

        if (is_null($layout)) {
            $layout = $this->layout;
        }

        $view = new View($template, $layout);
        $view->set('controller', $this);
        $view->set($this);

        echo $view->render();
    }

    /**
     * Redirect request to $url
     *
     * @param string|array $url
     * @param integer $status
     * @return false
     */
    protected function redirect ($url, $status = 302) {
        $this->perform();

        $codes = array(
            301 => 'Moved Permanently',
            302 => 'Found',
            307 => 'Temporary Redirect'
        );

        if (isset($codes[$status])) {
            $this->header("HTTP/1.1 $status $codes[$status]");
        }

        $this->header("Location: $url");

        return false;
    }

    /**
     * Throw a exception if controller has performed and set performed as true if not
     *
     * @throws Controller\DoubleRenderException
     */
    private function perform () {
        if ($this->performed) {
            throw new Controller\DoubleRenderException('Can only render or redirect once per action');
        }

        $this->performed = true;
    }

    /**
     * Wrapper to header function
     *
     * @param string $string
     * @param boolean $replace
     * @param integer $http_response_code
     */
    protected function header ($string, $replace = true, $http_response_code = null) {
        header($string, $replace, $http_response_code);
    }
}

