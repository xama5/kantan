<?php

namespace Kantan;

/**
 * Do not edit anything in this file
 * Please go to /Functions to add additional functionality to your theme.
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

define('KANTAN_SRC_DIRECTORY', __DIR__);

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = KANTAN_SRC_DIRECTORY . '/../vendor/autoload.php')) {
        wp_die(
            "You're not using the packaged version of this theme. Either download the pre-packaged version or run composer install",
            'Autoloader not found'
        );
    }
    require_once $composer;
}

/**
 * Kantan required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) {
    $file = "/../src/app/{$file}.php";
    if (!locate_template($file, true, true)) {
        wp_die(sprintf('Error locating <code>%s</code> for inclusion.', $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters']);

require(KANTAN_SRC_DIRECTORY . '/lib/tgm_plugin_activation.php');

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/kantan/Theme
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/kantan/Theme/Templates
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/kantan/Theme
 *
 * We do this so that the Template Hierarchy will look in themes/kantan/Theme/Templates for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/kantan/Theme
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/wp-content/themes/kantan/Theme
 * get_stylesheet_directory() -> /srv/www/example.com/wp-content/themes/kantan/Theme
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/wp-content/themes/kantan/Theme/Templates
 * └── TEMPLATEPATH           -> /srv/www/example.com/wp-content/themes/kantan/Theme
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require KANTAN_SRC_DIRECTORY.'/config/assets.php',
            'theme' => require KANTAN_SRC_DIRECTORY.'/config/theme.php',
            'view' => require KANTAN_SRC_DIRECTORY.'/config/view.php',
        ]);
    }, true);
