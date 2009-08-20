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
 * @category   Inflector
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version    0.1
 */

require_once __DIR__ . '/../TestHelper.php';

/**
 * Config test class
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   Inflector
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 */
class InflectorTest extends PHPUnit_Framework_TestCase {
    public function testPluralAndPluralize () {
        Inflector::plural ( '/$/', 's' );

        $this->assertEquals ( 'tests', Inflector::pluralize ( 'test' ) );
    }

    public function testSingularAndSingularize () {
        Inflector::singular ( '/s$/', '' );

        $this->assertEquals ( 'test', Inflector::singularize ( 'tests' ) );
    }

    public function testUncountable () {
        Inflector::uncountable ( 'equipment' );

        $this->assertEquals ( 'equipment', Inflector::pluralize ( 'equipment' ) );
        $this->assertEquals ( 'equipment', Inflector::singularize ( 'equipment' ) );

        Inflector::uncountable ( array ( 'fish' ) );

        $this->assertEquals ( 'fish', Inflector::pluralize ( 'fish' ) );
        $this->assertEquals ( 'fish', Inflector::singularize ( 'fish' ) );
    }

    public function testIrregular () {
        Inflector::irregular ( 'person', 'people' );

        $this->assertEquals ( 'person', Inflector::singularize ( 'person' ) );
        $this->assertEquals ( 'person', Inflector::singularize ( 'people' ) );
        $this->assertEquals ( 'people', Inflector::pluralize ( 'person' ) );
        $this->assertEquals ( 'people', Inflector::pluralize ( 'people' ) );
    }

    public function testFlush () {
        Inflector::flush ();

        $this->assertEquals ( 'person', Inflector::pluralize ( 'person' ) );
        $this->assertEquals ( 'people', Inflector::singularize ( 'people' ) );
    }

    public function testCamelize () {
        $this->assertEquals ( 'Foo', Inflector::camelize ( 'foo' ) );
        $this->assertEquals ( 'FooBar', Inflector::camelize ( 'foo_bar' ) );
        $this->assertEquals ( 'foo\BarBaz', Inflector::camelize ( 'foo/bar_baz', true ) );
    }

    public function testUnderscore () {
        $this->assertEquals ( 'foo', Inflector::underscore ( 'Foo' ) );
        $this->assertEquals ( 'foo_bar', Inflector::underscore ( 'FooBar' ) );
        $this->assertEquals ( 'foo/bar_baz', Inflector::underscore ( 'foo\BarBaz' ) );
    }
}
