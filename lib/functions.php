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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Core PHP Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    Core
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

/**
 * Namespace separator
 *
 * @var string
 */
const NAMESPACE_SEPARATOR = '\\';

/**
 * Autoload the received class
 *
 * @param string $class
 */
function __autoload ($class) {
    if (preg_match('/[^\\\a-z\d_]/i', $class)) {
        return false;
    }

    $file = str_replace(NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $class) . '.php';
    $fh = @fopen($file, 'r', true);

    if ($fh) {
        fclose($fh);
        require_once $file;
    }
}

/**
 * Append paths to include_path
 *
 * @param string $path
 * @param string $...
 * @return string the old include_path on success or false on failure
 */
function append_include_path ($path) {
    $paths = implode(PATH_SEPARATOR, func_get_args());

    return set_include_path(get_include_path() . PATH_SEPARATOR . $paths);
}

/**
 * I believe that mb_lcfirst will be soon added in PHP, but for now this could be useful
 *
 * @param string $word
 * @param string $encoding
 * @return string
 */
function mb_lcfirst ($word, $encoding = null) {
    if (!$encoding) {
        $encoding = mb_internal_encoding();
    }

    return mb_strtolower(mb_substr($word, 0, 1, $encoding), $encoding)
         . mb_substr($word, 1, mb_strlen($word, $encoding) - 1, $encoding);
}

/**
 * Get a $_REQUEST value or the $default if not set
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function param ($key, $default = null) {
    return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
}

