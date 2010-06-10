<?php

/**
 * Core PHP Framework
 * Copyright ( C ) 2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 *
 * This file is part of Core PHP Framework.
 *
 * Core PHP Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * ( at your option ) any later version.
 *
 * Core PHP Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Core PHP Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package	Core
 * @subpackage Inflector
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license	http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 ( LGPLv3 )
 * @version	0.1
 */

/**
 * Inflector class
 *
 * @package	Core
 * @subpackage Inflector
 * @copyright  2008-2009 Gabriel Sobrinho <gabriel@corephp.org>
 * @license	http://opensource.org/licenses/lgpl-3.0.html GNU Lesser General Public License version 3 ( LGPLv3 )
 */
abstract class Inflector {
	/**
	 * Plural rules
	 *
	 * @var array
	 */
	protected static $plurals = array ( 
		array( '/^kine|cow$/i', 'kine' ),
		array( '/^moves|move$/i', 'moves' ),
		array( '/^sexes|sex$/i', 'sexes' ),
		array( '/^children|child$/i', 'children' ),
		array( '/^men|man$/i', 'men' ),
		array( '/^people|person$/i', 'people' ),
		array( '/( quiz )$/i', '\\1zes' ),
		array( '/^( ox )$/i', '\\1en' ),
		array( '/( [m|l] )ouse$/i', '\\1ice' ),
		array( '/( matr|vert|ind )( ?:ix|ex )$/i', '\\1ices' ),
		array( '/( x|ch|ss|sh )$/i', '\\1es' ),
		array( '/( [^aeiouy]|qu )y$/i', '\\1ies' ),
		array( '/( hive )$/i', '\\1s' ),
		array( '/( ?:( [^f] )fe|( [lr] )f )$/i', '\\1\\2ves' ),
		array( '/sis$/i', 'ses' ),
		array( '/( [ti] )um$/i', '\\1a' ),
		array( '/( buffal|tomat )o$/i', '\\1oes' ),
		array( '/( bu )s$/i', '\\1ses' ),
		array( '/( alias|status )$/i', '\\1es' ),
		array( '/( octop|vir )us$/i', '\\1i' ),
		array( '/( ax|test )is$/i', '\\1es' ),
		array( '/s$/i', 's' ),
		array( '/$/', 's' )  );

	/**
	 * Singular rules
	 *
	 * @var array
	 */
	protected static $singulars = array ( 
		array( '/^cow|kine$/i', 'cow' ),
		array( '/^move|moves$/i', 'move' ),
		array( '/^sex|sexes$/i', 'sex' ),
		array( '/^child|children$/i', 'child' ),
		array( '/^man|men$/i', 'man' ),
		array( '/^person|people$/i', 'person' ),
		array( '/( quiz )zes$/i', '\\1' ),
		array( '/( matr )ices$/i', '\\1ix' ),
		array( '/( vert|ind )ices$/i', '\\1ex' ),
		array( '/^( ox )en/i', '\\1' ),
		array( '/( alias|status )es$/i', '\\1' ),
		array( '/( octop|vir )i$/i', '\\1us' ),
		array( '/( cris|ax|test )es$/i', '\\1is' ),
		array( '/( shoe )s$/i', '\\1' ),
		array( '/( o )es$/i', '\\1' ),
		array( '/( bus )es$/i', '\\1' ),
		array( '/( [m|l] )ice$/i', '\\1ouse' ),
		array( '/( x|ch|ss|sh )es$/i', '\\1' ),
		array( '/( m )ovies$/i', '\\1ovie' ),
		array( '/( s )eries$/i', '\\1eries' ),
		array( '/( [^aeiouy]|qu )ies$/i', '\\1y' ),
		array( '/( [lr] )ves$/i', '\\1f' ),
		array( '/( tive )s$/i', '\\1' ),
		array( '/( hive )s$/i', '\\1' ),
		array( '/( [^f] )ves$/i', '\\1fe' ),
		array( '/( ^analy )ses$/i', '\\1sis' ),
		array( '/( ( a )naly|( b )a|( d )iagno|( p )arenthe|( p )rogno|( s )ynop|( t )he )ses$/i', '\\1\\2sis' ),
		array( '/( [ti] )a$/i', '\\1um' ),
		array( '/( n )ews$/i', '\\1ews' ),
		array( '/s$/i', '' )  );

	/**
	 * Uncountable words
	 *
	 * @var array
	 */
	protected static $uncountables = array( 'equipment', 'information', 'rice', 'money', 'species', 'series', 'fish', 'sheep' );

	/**
	 * Add a new plural rule
	 *
	 * @param string $rule
	 * @param string $replacement
	 */
	public static function plural ( $rule, $replacement ) {
		array_unshift( self::$plurals, array( $rule, $replacement ) );
	}

	/**
	 * Add a new singular rule
	 *
	 * @param string $rule
	 * @param string $replacement
	 */
	public static function singular ( $rule, $replacement ) {
		array_unshift( self::$singulars, array( $rule, $replacement ) );
	}

	/**
	 * Add a new irregular rule
	 *
	 * @param string $singular
	 * @param string $plural
	 */
	public static function irregular ( $singular, $plural ) {
		self::plural( "/^$singular|$plural$/i", $plural );
		self::singular( "/^$plural|$singular$/i", $singular );
	}

	/**
	 * Add a new uncountable words
	 *
	 * @param string|array $words
	 */
	public static function uncountable ( $words ) {
		$words = array_map( 'mb_strtolower', ( array ) $words );
		self::$uncountables = array_merge( self::$uncountables, $words );
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
	public static function pluralize ( $word ) {
		if ( in_array( mb_strtolower( $word ), self::$uncountables ) ) {
			return $word;
		}

		foreach ( self::$plurals as $rule ) {
			if ( preg_match( $rule[0], $word ) ) {
				return preg_replace( $rule[0], $rule[1], $word );
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
	public static function singularize ( $word ) {
		if ( in_array( mb_strtolower( $word ), self::$uncountables ) ) {
			return $word;
		}

		foreach ( self::$singulars as $rule ) {
			if ( preg_match( $rule[0], $word ) ) {
				return preg_replace( $rule[0], $rule[1], $word );
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
	public static function camelize ( $word, $lcfirst = false ) {
		$word = str_replace( DIRECTORY_SEPARATOR, NAMESPACE_SEPARATOR, $word );
		$word = preg_replace( '/^.|[\\\_]./e', "mb_strtoupper( '\\0' )", $word );
		$word = str_replace( '_', '', $word );

		if ( $lcfirst ) {
			$word = mb_lcfirst( $word );
		}

		return $word;
	}

	/**
	 * Underscore the word - Also convert NAMESPACE_SEPARATOR to DIRECTORY_SEPARATOR to convert path names
	 *
	 * @param string $word
	 * @return string
	 */
	public static function underscore ( $word ) {
		$word = str_replace( NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $word );
		$word = preg_replace( '/( [A-Z]+ )( [A-Z][a-z] )/', '\1_\2', $word );
		$word = preg_replace( '/( [a-z\d] )( [A-Z] )/', '\1_\2', $word );
		$word = str_replace( '-', '_', mb_strtolower( $word ) );

		return $word;
	}

	/**
	 * Slugarize the word removing accented chars. For example 'ãéüöí ìàíèção nãoñ'
	 * will be 'aeuoi-iaiecao-naon'
	 *
	 * @param string $word
	 * @param string $delimiter
	 * @return string
	 */
	public static function slug ( $word, $delimiter = '-' )
	{
		$word = str_replace( "'", '', $word );
		$word = iconv( 'UTF-8', 'ASCII//TRANSLIT', $word );
		$word = preg_replace( '/[^a-z\d]+/i', $delimiter, $word );
		$word = strtolower( trim( $word, $delimiter ) );

		return $word;
	}
}