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
 * @subpackage UnitTests
 * @category   Request
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

namespace Controller;

/**
 * @see test_helper.php
 */
require_once __DIR__ . '/../../test_helper.php';

/**
 * Router tests
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   Request
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class RequestTest extends \PHPUnit_Framework_TestCase {
    protected function makeAndAssertRequest ($type) {
        if (Request::GET == $type || Request::POST == $type) {
            $_SERVER['REQUEST_METHOD'] = $type;
        } else {
            $_SERVER['REQUEST_METHOD'] = 'POST';
            $_REQUEST['_method'] = $type;
        }

        $request = new Request;

        $this->assertEquals(Request::GET == $type, $request->isGet());
        $this->assertEquals(Request::POST == $type, $request->isPost());
        $this->assertEquals(Request::PUT == $type, $request->isPut());
        $this->assertEquals(Request::DELETE == $type, $request->isDelete());
        $this->assertEquals(Request::HEAD == $type, $request->isHead());
    }

    public function testIsGet () {
        $this->makeAndAssertRequest(Request::GET);
    }

    public function testIsPost () {
        $this->makeAndAssertRequest(Request::POST);
    }

    public function testIsPut () {
        $this->makeAndAssertRequest(Request::PUT);
    }

    public function testIsDelete () {
        $this->makeAndAssertRequest(Request::DELETE);
    }

    public function testIsHead () {
        $this->makeAndAssertRequest(Request::HEAD);
    }

    public function testIsAjax () {
        $request = new Request;

        $this->assertFalse($request->isAjax());

        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XmlHttpRequest';

        $this->assertTrue($request->isAjax());
    }

    public function testReferer () {
        $request = new Request;

        $this->assertEquals('/', $request->referer());

        $_SERVER['HTTP_REFERER'] = 'http://www.example.com/';

        $this->assertEquals('http://www.example.com/', $request->referer());
    }
}

