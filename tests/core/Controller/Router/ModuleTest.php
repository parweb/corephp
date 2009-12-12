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
 * @category   Router
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

namespace Controller\Router;

/**
 * @see test_helper.php
 */
require_once __DIR__ . '/../../../test_helper.php';

/**
 * Module tests
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   Router
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class ModuleTest extends \PHPUnit_Framework_TestCase {
    protected $module;

    protected function setUp () {
        $this->module = new Module('admin', function ($admin) {
            $admin->submodule('crm', function ($system) {
                $system->connect('customers', array('controller' => 'customers'));
            });

            $admin->connect('/', array('controller' => 'dashboard'));
        });
    }

    protected function tearDown () {
        $this->module = null;
    }

    public function testMatch () {
        $options = $this->module->match('admin');

        $this->assertEquals('admin/dashboard', $options['controller']);
        $this->assertEquals('index', $options['action']);
        $this->assertEquals('html', $options['format']);
    }

    public function testMatchSubModule () {
        $options = $this->module->match('admin/crm/customers');

        $this->assertEquals('admin/crm/customers', $options['controller']);
        $this->assertEquals('index', $options['action']);
        $this->assertEquals('html', $options['format']);
    }
}

