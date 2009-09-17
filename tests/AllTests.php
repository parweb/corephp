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
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version    0.1
 */

require_once 'TestHelper.php';

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AllTests::main');
}

class AllTests {
    public static function suite () {
        $suite = new PHPUnit_Framework_TestSuite('Core PHP');
        $suite->addTest(Core\AllTests::suite());

        return $suite;
    }

    public static function main () {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }
}

if (PHPUnit_MAIN_METHOD == 'AllTests::main') {
    AllTests::main();
}

