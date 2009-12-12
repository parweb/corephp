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
 * @category   Session
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
 * Session tests
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   Session
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class SessionTest extends \PHPUnit_Framework_TestCase {
    protected $session;

    protected function setUp () {
        $this->session = new Session;
    }

    protected function tearDown () {
        $this->session = null;
    }

    public function testIsset () {
        $this->assertFalse(isset($this->session->foo));

        $this->session->foo = true;

        $this->assertTrue(isset($this->session->foo));
    }

    public function testUnset () {
        $this->assertTrue(isset($this->session->foo));

        unset($this->session->foo);

        $this->assertFalse(isset($this->session->foo));
    }

    public function testSetAndGet () {
        $this->session->bar = 'bar';

        $this->assertEquals('bar', $this->session->bar);

        unset($this->session->bar);
    }

    public function testFlash () {
        // Initial state
        $this->assertFalse(isset($this->session->flash));

        $this->session->flash = 'foo';
        $this->assertEquals('foo', $this->session->flash);

        // Next request
        $this->tearDown();
        $this->setUp();

        $this->assertTrue(isset($this->session->flash));
        $this->assertEquals('foo', $this->session->flash);

        // Next request
        $this->tearDown();
        $this->setUp();

        $this->assertFalse(isset($this->session->flash));
    }

    public function testFlashTwice () {
        // Initial state
        $this->assertFalse(isset($this->session->flash));

        $this->session->flash = 'foo';
        $this->assertEquals('foo', $this->session->flash);

        // Next request
        $this->tearDown();
        $this->setUp();

        $this->assertTrue(isset($this->session->flash));
        $this->assertEquals('foo', $this->session->flash);

        $this->session->flash = 'bar';
        $this->assertEquals('bar', $this->session->flash);

        // Next request
        $this->tearDown();
        $this->setUp();

        $this->assertTrue(isset($this->session->flash));
        $this->assertEquals('bar', $this->session->flash);

        // Next request
        $this->tearDown();
        $this->setUp();

        $this->assertFalse(isset($this->session->flash));
    }
}

