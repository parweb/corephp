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
 * @package   Core
 * @copyright 2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license   http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 * @version   0.1
 */

/**
 * Observer class
 *
 * @package   Core
 * @copyright 2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license   http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (GPLv3)
 */
abstract class Observer {
    /**
     * Current observers
     *
     * @var array
     */
    protected static $observers = array ();

    /**
     * Attach a observer
     *
     * @param string $event
     * @param callback $observer
     */
    public static function attach ($event, $observer) {
        self::$observers[get_called_class()][$event][] = $observer;
    }

    /**
     * Deattach a observer
     *
     * @param string $event
     * @param callback $observer
     */
    public static function deattach ($event, $observer) {
        $class = get_called_class();

        if (isset(self::$observers[$class][$event])) {
            foreach (self::$observers[$class][$event] as $key => $value) {
                if ($observer === $value) {
                    unset(self::$observers[$class][$event][$key]);
                    break;
                }
            }
        }
    }

    /**
     * Notify all observers about a event
     *
     * @param string $event
     * @param array $args Arguments passed to callbacks
     */
    public static function notify ($event, array $args = array ()) {
        $class = get_called_class();

        if (isset(self::$observers[$class][$event])) {
            foreach (self::$observers[$class][$event] as $observer) {
                call_user_func_array($observer, $args);
            }
        }
    }

    /**
     * A shortcut to Observer::attach("before_$event", $observer)
     *
     * @param string $event
     * @param callback $observer
     */
    public static function before ($event, $observer) {
        self::attach("before_$event", $observer);
    }

    /**
     * A shortcut to Observer::attach("after_$event", $observer)
     *
     * @param string $event
     * @param callback $observer
     */
    public static function after ($event, $observer) {
        self::attach("after_$event", $observer);
    }

    /**
     * A shortcut to Observer::attach("before_$event", $observer) and Observer::attach("after_$event", $observer)
     *
     * @param string $event
     * @param callback $observer
     */
    public static function around ($event, $observer) {
        self::before($event, $observer);
        self::after($event, $observer);
    }
}

