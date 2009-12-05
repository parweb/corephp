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
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

/**
 * @see test_helper.php
 */
require_once __DIR__ . '/../test_helper.php';

/**
 * Inflector tests
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   Inflector
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class InflectorTest extends PHPUnit_Framework_TestCase {
    protected $backupStaticAttributes = true;

    protected function setUp () {
        Inflector::flush();
    }

    public function testPluralize () {
        Inflector::plural('/$/', 's');

        $this->assertEquals('cores', Inflector::pluralize('core'));
    }

    public function testSingularize () {
        Inflector::singular('/s$/i', '');

        $this->assertEquals('core', Inflector::singularize('cores'));
    }

    public function testUncountable () {
        Inflector::uncountable(array('equipment', 'fish'));

        $this->assertEquals('equipment', Inflector::pluralize('equipment'));
        $this->assertEquals('equipment', Inflector::singularize('equipment'));
        $this->assertEquals('fish', Inflector::pluralize('fish'));
        $this->assertEquals('fish', Inflector::singularize('fish'));
    }

    public function testIrregular () {
        Inflector::irregular('person', 'people');

        $this->assertEquals('person', Inflector::singularize('person'));
        $this->assertEquals('person', Inflector::singularize('people'));
        $this->assertEquals('people', Inflector::pluralize('person'));
        $this->assertEquals('people', Inflector::pluralize('people'));
    }

    public function testFlush () {
        // flush is called on setUp
        $this->assertEquals('core', Inflector::pluralize('core'));
        $this->assertEquals('cores', Inflector::singularize('cores'));
        $this->assertEquals('person', Inflector::pluralize('person'));
        $this->assertEquals('people', Inflector::singularize('people'));
    }

    public function testCamelize () {
        $this->assertEquals('Home', Inflector::camelize('home'));
        $this->assertEquals('HomeController', Inflector::camelize('home_controller'));
        $this->assertEquals('user\ArticlesController', Inflector::camelize('user/articles_controller', true));
    }

    public function testUnderscore () {
        $this->assertEquals('home', Inflector::underscore('Home'));
        $this->assertEquals('home_controller', Inflector::underscore('HomeController'));
        $this->assertEquals('user/articles_controller', Inflector::underscore('user\ArticlesController'));
    }

    public function testSlug () {
        $this->assertEquals('johns', Inflector::slug("John's"));
        $this->assertEquals('aeuoi-iaiecao-naon', Inflector::slug('ãéüöí ìàíèção nãoñ'));
        $this->assertEquals('i-can-use-amp-and-atilde', Inflector::slug('I can use &amp; and &atilde;'));
        $this->assertEquals('pound-double-quote-asterisk', Inflector::slug('£ pound " double quote * asterisk '));
    }
}

