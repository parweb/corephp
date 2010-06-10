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
 * @subpackage Cache
 * @category   Adapters
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 * @version    0.1
 */

namespace Cache\Adapters;

/**
 * File adapter class
 *
 * @package    Core
 * @subpackage Cache
 * @category   Adapters
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license    http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 (LGPLv3)
 */
 
class File implements \Cache\Adapter {
    /**
     * Verify file cache support
     *
     * @throws \Cache\Exception when cache dir isn't writable
     */
    public function __construct () {
        $this->directory = \Config::get( 'cache.directory', 'tmp/cache' );

        if( !is_dir($this->directory ) || !is_writable( $this->directory ) ) {
            throw new \Cache\Exception( "Cache directory `$this->directory' does not exists or is not writable" );
        }

        $this->directory = realpath( $this->directory );
    }

    /**
     * (non-PHPdoc)
     * @see \Cache\Adapter::get()
     */
    public function get ( $key ) {
        $fileName = $this->getFileName( $key );

        if ( !file_exists( $fileName ) ) {
            return false;
        }

        list( $expires, $data ) = unserialize( file_get_contents( $fileName ) );

        if ( $expires && $expires <= time() ) {
            $this->delete( $key );
            return false;
        }

        return $data;
    }

    /**
     * (non-PHPdoc)
     * @see \Cache\Adapter::set()
     */
    public function set ( $key, $value, $ttl = 0 ) {
        if ( $ttl ) {
            $ttl = time() + $ttl;
        }

        $data = serialize( array( $ttl, $value ) );

        return (bool)file_put_contents( $this->getFileName( $key ), $data, LOCK_EX );
    }

    /**
     * (non-PHPdoc)
     * @see \Cache\Adapter::delete()
     */
    public function delete ( $key ) {
        return unlink( $this->getFileName( $key ) );
    }

    /**
     * (non-PHPdoc)
     * @see \Cache\Adapter::flush()
     */
    public function flush () {
        $pattern = $this->directory . DIRECTORY_SEPARATOR . '*';

        foreach( new \GlobIterator( $pattern, \GlobIterator::CURRENT_AS_PATHNAME ) as $file ) {
            unlink( $file );
        }

        return true;
    }

    /**
     * Get file name of $key
     *
     * @param string $key
     * @return string
     */
    protected function getFileName ( $key ) {
        return $this->directory . DIRECTORY_SEPARATOR . md5( $key );
    }
}