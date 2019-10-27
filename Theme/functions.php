<?php

namespace Kantan;

require(get_template_directory() . '/../src/functions.php');

/**
 * Define any constants here
 */
define('DISABLE_NAG_NOTICES', true);

require(locate_template('actions.php'));
require(locate_template('filters.php'));