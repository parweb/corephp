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
 * @subpackage View
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

/**
 * View class
 *
 * @package    Core
 * @subpackage View
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
class View {
    /**
     * Current template
     *
     * @var string
     */
    protected $template;

    /**
     * Current layout
     *
     * @var string
     */
    protected $layout;

    /**
     * Template data
     *
     * @var array
     */
    protected $data = array();

    /**
     * Configure view paths
     *
     * @param string $template
     * @param string $layout
     */
    public function __construct ($template, $layout = null) {
        $this->template = 'app/views/' . Inflector::underscore($template) . '.phtml';

        if ($layout) {
            $this->layout = 'app/layouts/' . Inflector::underscore($layout) . '.phtml';
        }
    }

    /**
     * Set template data
     *
     * @param string|array|object $spect
     * @param mixed $value
     */
    public function set ($spec, $value = null) {
        if (is_array($spec) || is_object($spec)) {
            foreach ($spec as $key => $value) {
                $this->data[$key] = $value;
            }
        } else {
            $this->data[$spec] = $value;
        }
    }

    /**
     * Get template data
     *
     * @param string $spec
     */
    public function get ($spec) {
        return isset($this->data[$spec]) ? $this->data[$spec] : null;
    }

    public function render () {
        var_dump($this);
    }
}

