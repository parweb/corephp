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
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version    0.1
 */

namespace Core;

require_once __DIR__ . '/../../TestHelper.php';

/**
 * Controller test class
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   Controller
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 */
class ControllerTest extends \PHPUnit_Framework_TestCase {
    /**
     * @expectedException Core\Controller\Exception
     */
    public function testFactoryInexistentController () {
        Controller::factory('inexistent');
    }

    /**
     * @expectedException Core\Controller\Exception
     */
    public function testFactoryInvalidController () {
        Controller::factory('invalid');
    }

    public function testFactoryValidController () {
        Controller::factory('index');
    }

    /**
     * @expectedException Core\Controller\Exception
     */
    public function testDispatchInexistentAction () {
        Controller::dispatch('index', 'inexistent');
    }

    /**
     * @expectedException Core\Controller\Exception
     */
    public function testDispatchProtectedAction () {
        Controller::dispatch('index', 'protected_action');
    }

    public function testDispatchPublicAction () {
        $this->assertEquals('IndexController::index', Controller::dispatch('index', 'index'));
    }
}
