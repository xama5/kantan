<?php
namespace KantanCompiler\Assets\Css;

use Assetic\Filter\CompassFilter;
use KantanCompiler\Filter\ScssphpFilter;
use KantanCompiler\Filter\AutoprefixerFilter;
use Assetic\Filter\CssRewriteFilter;

/**
 * Scss custom cache saving
 *
 * @author Alessandro Carbone <ale.carbo@gmail.com>
 */
class Scss extends \KantanCompiler\Assets\Factory {
	/**
	 * Constructor
	 * 
	 * @param array $content The files to save to cache
	 * @param string $cachefile The cache file name
	 * @param object $manager The Factory object
	 */
	public function __construct($content, $cachefile, $manager) {
		$this->manager = $manager;
		parent::__construct( $this );
		$manager->cache->fs->set( $cachefile, $this->createAsset( $content, $this->getFilters() )->dump() );
	}

	public function setFilters() {
		$this->setFilter('Scssphp', new ScssphpFilter)
			->setFilter('Autoprefix', new AutoprefixerFilter)
			->setFilter('CssRewrite', new CssRewriteFilter);
	}
}