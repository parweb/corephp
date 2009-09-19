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
    protected $observers = array ();

    /**
     * Attach a observer
     *
     * @param string event
     * @param callback $observer
     */
    protected function attach ($event, $observer) {
        $this->observers[$event][] = $observer;
    }

    /**
     * Deattach a observer
     *
     * @param string event
     * @param callback $observer
     */
    protected function deattach ($event, $observer) {
        if (isset($this->observers[$event])) {
            foreach ($this->observers[$event] as $key => $value) {
                if ($observer === $value) {
                    unset($this->observers[$event][$key]);
                    break;
                }
            }
        }
    }

    /**
     * Notify all observers about a event
     *
     * @var string $event
     * @var array $args Arguments passed to callbacks
     */
    protected function notify ($event, array $args = array ()) {
        if (isset($this->observers[$event])) {
            foreach ($this->observers[$event] as $observer) {
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
    protected function before ($event, $observer) {
        $this->attach("before_$event", $observer);
    }

    /**
     * A shortcut to Observer::attach("after_$event", $observer)
     *
     * @param string $event
     * @param callback $observer
     */
    protected function after ($event, $observer) {
        $this->attach("after_$event", $observer);
    }

    /**
     * A shortcut to Observer::attach("before_$event", $observer) and Observer::attach("after_$event", $observer)
     *
     * @param string $event
     * @param callback $observer
     */
    protected function around ($event, $observer) {
        $this->before($event, $observer);
        $this->after($event, $observer);
    }
}

