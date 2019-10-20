<?php

namespace Kantan;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('kantan/theme.scss', asset_path('theme.scss'), false, null);
    wp_enqueue_script('kantan/theme.js', asset_path('theme.js'), ['jquery'], null, true);
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    // Auto-manage activation of plugins
    \PrimeTime\WordPress\PluginManifest\Activation::set(get_template_directory() . '/plugin-manifest.yml', WP_ENV);
}, 20);

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    kantan('blade')->share('post', $post);
});

/**
 * Setup kantan options
 */
add_action('after_setup_theme', function () {
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
});

define('SIMPLE_WP_PLUGINS', json_decode(file_get_contents(get_template_directory() . '/plugins.json'), true));
add_action( 'tgmpa_register', function() {
    // Allow source to be in the format "fs:plugins/some-plugin.zip" so we don't have to add a fully qualified file path in the json file
    // fs: is relative to this theme
    $plugins = array_map(function($plugin) {
        if (isset($plugin['source']) && strpos($plugin['source'], 'fs:') === 0) {
            $plugin['source'] = get_template_directory() . '/' . substr($plugin['source'], 3);
        }
        return $plugin;
    }, SIMPLE_WP_PLUGINS);

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

    tgmpa( $plugins, $config );
});
add_filter('site_transient_update_plugins', function($value) {
    foreach (SIMPLE_WP_PLUGINS as $plugin) {
        if (@$plugin['update'] === false) {
            unset($value->response[$plugin['slug'] . '/' . $plugin['slug'] . '.php']);
        }
    }
    return $value;
});