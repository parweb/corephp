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
 * @category   ProceduralFunctions
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version    0.1
 */

namespace Core;

require_once __DIR__ . '/../../TestHelper.php';

/**
 * Procedural functions test class
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   ProceduralFunctions
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 */
class ProceduralFunctionsTest extends \PHPUnit_Framework_TestCase {
    public function testAutoloadWithInvalidClassName () {
        $this->assertFalse(__autoload('invalid class name'));
    }

    public function testAppendIncludePath () {
        $original = get_include_path();

        $this->assertEquals($original, append_include_path(__DIR__));
        $this->assertEquals($original . PATH_SEPARATOR . __DIR__, get_include_path());

        set_include_path($original);
    }

    public function testMbLcfirst () {
        $this->assertEquals('çÇÇ', mb_lcfirst('ÇÇÇ', 'utf-8'));
    }
}

