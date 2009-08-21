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

require_once 'PHPUnit/Framework.php';

// Buffer and error reporting
ob_start ();
error_reporting ( E_ALL | E_STRICT );

// Go to framework dir
chdir ( dirname ( __DIR__ ) );

// Set include path
$include_path = implode ( PATH_SEPARATOR, array_map ( 'realpath', array ( 'lib', 'app/controllers' ) ) );
set_include_path ( $include_path . PATH_SEPARATOR . get_include_path () );

unset ( $include_path );

// Autoload
require 'inflector.php';
require 'functions.php';

