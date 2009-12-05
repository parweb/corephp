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
 * @category   Procedural
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

/**
 * @see test_helper.php
 */
require_once __DIR__ . '/../test_helper.php';

/**
 * Procedural tests
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   Procedural
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class ProceduralTest extends PHPUnit_Framework_TestCase {
    public function testAutoloadWithInvalidClassName () {
        $this->assertFalse(__autoload('invalid class name'));
    }

    public function testAppendIncludePath () {
        $before = get_include_path();
        $after = get_include_path() . PATH_SEPARATOR . __DIR__;

        $this->assertEquals($before, append_include_path(__DIR__));
        $this->assertEquals($after, get_include_path());

        set_include_path($before);
    }

    public function testMbLcfirst () {
        $this->assertEquals('çÇÇ', mb_lcfirst('ÇÇÇ', 'utf-8'));
    }

    public function testParam () {
        $_REQUEST['user_id'] = 1;
        $this->assertEquals(1, param('user_id'));
    }

    public function testParamWithDefaultValue () {
        $this->assertEquals(0, param('user_id', 0));
    }
}

