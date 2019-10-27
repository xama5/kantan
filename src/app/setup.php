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
     * Auto-manage activation of plugins
     */
    if (!defined('WP_ENV'))
        define('WP_ENV', 'production');
    \PrimeTime\WordPress\PluginManifest\Activation::set(get_template_directory() . '/plugin-manifest.yml', WP_ENV);

    /**
     * Flush Kantan Compiler Cache
     * We're doing so by checking the Assets directory recursively for the most recently changed file.
     */
    $asset_files = glob(get_stylesheet_directory() . '/Assets{,/*}/*.*', GLOB_BRACE);
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

/**
 * Manage required and suggested plugins
 */
if (!defined('KANTAN_WP_PLUGINS'))
    define('KANTAN_WP_PLUGINS', json_decode(file_get_contents(get_template_directory() . '/plugins.json'), true));

add_action( 'tgmpa_register', function() {
    $config = [
        'id'           => 'kantan',             // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'kantan-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
    ];

    tgmpa( KANTAN_WP_PLUGINS, $config );
});

add_filter('site_transient_update_plugins', function($value) {
    foreach (KANTAN_WP_PLUGINS as $plugin) {
        if (@$plugin['update'] === false) {
            unset($value->response[$plugin['slug'] . '/' . $plugin['slug'] . '.php']);
        }
    }
    return $value;
});