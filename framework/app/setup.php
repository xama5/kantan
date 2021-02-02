<?php

namespace Kantan;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Setup kantan options
 */
add_action('after_setup_theme', function () {
    /**
     * Flush Kantan Compiler Cache
     * We're doing so by checking the Assets directory recursively for the most recently changed file.
     */
    $asset_files = glob(get_stylesheet_directory() . '/assets{,/*}/*.*', GLOB_BRACE);
    $asset_files = array_map('filemtime', $asset_files);
    arsort($asset_files);
    $mtime = current($asset_files);
    if (get_option('kantan_asset_mtime', 0) < $mtime) {
        do_action('kantan_compiler_flush_cache');
        update_option('kantan_asset_mtime', $mtime);
    }

    /**
     * Add Blade to kantan container
     */
    kantan()->singleton('kantan.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    kantan('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
}, 20);

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    kantan('blade')->share('post', $post);
});