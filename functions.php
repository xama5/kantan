<?php

namespace Kantan;

/**
 * This file should not be edited, instead, edit config.php, actions.php and filters.php.
 */

/**
 * Kantan Core is required to correctly map the Kantan directories and compile blade templates.
 * Kantan Compiler should be installed, but is not required.
 */
if ( !is_admin() && !in_array('kantan-core/kantan-core.php', apply_filters('active_plugins', get_option('active_plugins'))) )
{
    wp_die(
        'Kantan Core plugin is not installed, please follow the steps described in the admin dashboard.',
        'Unmet dependencies'
    );
}

/**
 * These files can be overriden in a child theme.
 */
require(locate_template('config.php'));
require(locate_template('actions.php'));
require(locate_template('filters.php'));

/**
 * Manage required and suggested plugins
 */
require(get_template_directory() . '/Library/tgm_plugin_activation.php');
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
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
    ];

    $plugins = array_map(function($plugin) {
        if ($plugin['required'] === true) {
            $plugin['force_activation'] = true;
            $plugin['force_deactivation'] = true;
        }
        return $plugin;
    }, KANTAN_WP_PLUGINS);

    tgmpa( $plugins, $config );
});

/**
 * Some plugins share the same name with others in the official wordpress directory.
 * Thus, we get update notifications for plugins we didn't install.
 */
add_filter('site_transient_update_plugins', function($value) {
    foreach (KANTAN_WP_PLUGINS as $plugin) {
        if (@$plugin['update'] === false) {
            unset($value->response[$plugin['slug'] . '/' . $plugin['slug'] . '.php']);
        }
    }
    return $value;
});