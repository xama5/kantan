<?php
/**
 * Bootstrap class for AssetsMinify plugin.
 * It's the only entry point of this plugin.
 * A singleton class.
 *
 * @author Alessandro Carbone <ale.carbo@gmail.com>
 */

class KantanCompiler extends KantanCompiler\Pattern\Singleton {

	/**
	 * Constructor
	 */
	protected function __construct() {
		if ( !is_admin() )
			return new KantanCompiler\Init;
	}
}

KantanCompiler::getInstance();