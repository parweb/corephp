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
 * @category   Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

/**
 * @see test_helper.php
 */
require_once __DIR__ . '/../test_helper.php';

/**
 * Controller tests
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class ControllerTest extends PHPUnit_Framework_TestCase {
    /**
     * @expectedException Controller\Exception
     */
    public function testDispatchInexistentController () {
        Controller::dispatch('inexistent', 'index');
    }

    /**
     * @expectedException Controller\Exception
     */
    public function testDispatchInvalidController () {
        Controller::dispatch('invalid', 'index');
    }

    /**
     * @expectedException Controller\Exception
     */
    public function testDispatchInexistentAction () {
        Controller::dispatch('home', 'inexistent_action');
    }

    /**
     * @expectedException Controller\Exception
     */
    public function testDispatchProtectedAction () {
        Controller::dispatch('home', 'before_action');
    }

    public function testDispatchPublicAction () {
        $controller = Controller::dispatch('home', 'index');

        $this->assertTrue($controller->before);
        $this->assertEquals('HomeController::index', $controller->action);
        $this->assertTrue($controller->after);
    }

    public function testLazyLoadSessionAndRequest () {
        $controller = Controller::dispatch('home', 'index');

        $request = $controller->request;

        $this->assertType('Controller\Request', $request);
        $this->assertSame($request, $controller->request);

        $session = $controller->session;

        $this->assertType('Controller\Session', $session);
        $this->assertSame($session, $controller->session);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testVisiblityProtectionInLazyLoad () {
        $controller = Controller::dispatch('home', 'index');

        $this->assertEquals(null, $controller->layout);
    }
}

