<?php

namespace KantanCompiler\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\BaseNodeFilter;
use Padaliyajay\PHPAutoprefixer\Autoprefixer;

/**
 * Parses CSS and adds vendor prefixes to rules
 * @author xama5 <contact@oliver.la>
 */
class AutoprefixerFilter extends BaseNodeFilter
{

    public function __construct() {}

    public function filterLoad(AssetInterface $asset)
    {
        $input = $asset->getContent();
        $asset->setContent((new Autoprefixer($input))->compile());
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterDump(AssetInterface $asset)
    {
    }
}
