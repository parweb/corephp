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
 * @category   CacheAdapters
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

namespace Cache\Adapters;

use Config, Cache;

/**
 * @see test_helper.php
 */
require_once __DIR__ . '/../../../test_helper.php';

/**
 * APC adapter tests
 *
 * @package    Core
 * @subpackage UnitTests
 * @category   CacheAdapters
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class ApcTest extends \PHPUnit_Framework_TestCase {
    protected $backupStaticAttributes = true;

    public static function setUpBeforeClass () {
        Config::set('cache.adapter', 'apc');
    }

    protected function assertPreConditions () {
        try {
            Cache::getAdapter();
        } catch (\Cache\Exception $e) {
            $this->markTestSkipped($e->getMessage());
        }

        if (!ini_get('apc.enable_cli')) {
            $this->markTestSkipped('apc.enable_cli is disabled');
        }
    }

    public static function tearDownAfterClass () {
        Config::set('cache.adapter', 'file');
    }

    public function testSet () {
        $this->assertTrue(Cache::set('apc_test', 'apc_test'));
    }

    public function testGet () {
        $this->assertEquals('apc_test', Cache::get('apc_test'));
    }

    public function testDelete () {
        $this->assertTrue(Cache::delete('apc_test'));
    }

    public function testFlush () {
        $this->assertTrue(Cache::set('apc_flush_test', 'apc_flush_test'));
        $this->assertEquals('apc_flush_test', Cache::get('apc_flush_test'));
        $this->assertTrue(Cache::flush());
        $this->assertFalse(Cache::get('apc_flush_test'));
    }
}

