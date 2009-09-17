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
 * @subpackage Inflector
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version    0.1
 */

namespace Core;

/**
 * Inflector class
 *
 * @package    Core
 * @subpackage Inflector
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 */
abstract class Inflector {
    /**
     * Plural rules
     *
     * @var array
     */
    protected static $plurals = array();

    /**
     * Singular rules
     *
     * @var array
     */
    protected static $singulars = array();

    /**
     * Uncountable words
     *
     * @var array
     */
    protected static $uncountables = array();

    /**
     * Add a new plural rule
     *
     * @param string $rule
     * @param string $replacement
     */
    public static function plural ($rule, $replacement) {
        array_unshift(self::$plurals, array($rule, $replacement));
    }

    /**
     * Add a new singular rule
     *
     * @param string $rule
     * @param string $replacement
     */
    public static function singular ($rule, $replacement) {
        array_unshift(self::$singulars, array($rule, $replacement));
    }

    /**
     * Add a new irregular rule
     *
     * @param string $singular
     * @param string $plural
     */
    public static function irregular ($singular, $plural) {
        self::plural("/^$singular|$plural$/i", $plural);
        self::singular("/^$plural|$singular$/i", $singular);
    }

    /**
     * Add a new uncountable words
     *
     * @param string|array $words
     */
    public static function uncountable ($words) {
        $words = array_map('mb_strtolower', (array) $words);
        self::$uncountables = array_merge(self::$uncountables, $words);
    }

    /**
     * Flush all rules
     */
    public static function flush () {
        self::flushPlurals();
        self::flushSingulars();
        self::flushUncountables();
    }

    /**
     * Flush plural rules
     */
    public static function flushPlurals () {
        self::$plurals = array();
    }

    /**
     * Flush singular rules
     */
    public static function flushSingulars () {
        self::$singulars = array();
    }

    /**
     * Flush uncountable words
     */
    public static function flushUncountables () {
        self::$uncountables = array();
    }

    /**
     * Pluralize the word
     *
     * @param string $word
     * @return string
     */
    public static function pluralize ($word) {
        if (in_array(mb_strtolower($word), self::$uncountables)) {
            return $word;
        }

        foreach (self::$plurals as $rule) {
            if (preg_match($rule[0], $word)) {
                return preg_replace($rule[0], $rule[1], $word);
            }
        }

        return $word;
    }

    /**
     * Singularize the word
     *
     * @param string $word
     * @return string
     */
    public static function singularize ($word) {
        if (in_array(mb_strtolower($word), self::$uncountables)) {
            return $word;
        }

        foreach (self::$singulars as $rule) {
            if (preg_match($rule[0], $word)) {
                return preg_replace($rule[0], $rule[1], $word);
            }
        }

        return $word;
    }

    /**
     * Camelize the word - Also convert DIRECTORY_SEPARATOR to NAMESPACE_SEPARATOR to convert namespaces
     *
     * @param string $word
     * @param boolean $lcfirst
     * @return string
     */
    public static function camelize ($word, $lcfirst = false) {
        $word = str_replace(DIRECTORY_SEPARATOR, NAMESPACE_SEPARATOR, $word);
        $word = preg_replace('/^.|[\\\_]./e', "mb_strtoupper ( '\\0' )", $word);
        $word = str_replace('_', '', $word);

        if ($lcfirst) {
            $word = mb_lcfirst($word);
        }

        return $word;
    }

    /**
     * Underscore the word - Also convert NAMESPACE_SEPARATOR to DIRECTORY_SEPARATOR to convert path names
     *
     * @param string $word
     * @return string
     */
    public static function underscore ($word) {
        $word = str_replace(NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $word);
        $word = preg_replace('/([A-Z]+)([A-Z][a-z])/', '\1_\2', $word);
        $word = preg_replace('/([a-z\d])([A-Z])/', '\1_\2', $word);
        $word = str_replace('-', '_', mb_strtolower($word));

        return $word;
    }
}

