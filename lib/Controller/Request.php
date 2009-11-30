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
 * Controller request class
 *
 * @package    Core
 * @subpackage Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class Request {
    /**
     * GET method
     *
     * @var string
     */
    const GET = 'GET';

    /**
     * POST method
     *
     * @var string
     */
    const POST = 'POST';

    /**
     * HEAD method
     *
     * @var string
     */
    const HEAD = 'HEAD';

    /**
     * DELETE method
     *
     * @var string
     */
    const DELETE = 'DELETE';

    /**
     * PUT method
     *
     * @var string
     */
    const PUT = 'PUT';

    /**
     * Override request method if request is POST and param('_method') is valid
     */
    public function __construct () {
        if ($this->isPost() && $method = param('_method')) {
            $method = strtoupper($method);

            if (in_array($method, array(self::HEAD, self::DELETE, self::PUT))) {
                $_SERVER['REQUEST_METHOD'] = $method;
            }
        }
    }

    /**
     * GET request?
     *
     * @return boolean
     */
    public function isGet () {
        return self::GET == $_SERVER['REQUEST_METHOD'];
    }

    /**
     * POST request?
     *
     * @return boolean
     */
    public function isPost () {
        return self::POST == $_SERVER['REQUEST_METHOD'];
    }

    /**
     * HEAD request?
     *
     * @return boolean
     */
    public function isHead () {
        return self::HEAD == $_SERVER['REQUEST_METHOD'];
    }

    /**
     * DELETE request?
     *
     * @return boolean
     */
    public function isDelete () {
        return self::DELETE == $_SERVER['REQUEST_METHOD'];
    }

    /**
     * PUT request?
     *
     * @return boolean
     */
    public function isPut () {
        return self::PUT == $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Ajax request?
     *
     * @return boolean
     */
    public function isAjax () {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'XmlHttpRequest' == $_SERVER['HTTP_X_REQUESTED_WITH'];
    }
}

