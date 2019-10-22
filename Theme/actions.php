<?php

namespace Kantan;

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
    add_theme_support('soil-clean-up');
    add_theme_support('soil-disable-asset-versioning');
    add_theme_support('soil-disable-trackbacks');
    add_theme_support('soil-js-to-footer');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');
});