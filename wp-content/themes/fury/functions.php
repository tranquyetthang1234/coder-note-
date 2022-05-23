<?php
/**
 * Functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 * @since 1.2.80 Updated the code.
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Fury\Theme;
use Fury\Setup;

// Include the Fury theme class.
get_template_part( 'framework/classes/class-fury-theme' );

/**
 * Fury
 *
 * Access to the Fury theme class.
 *
 * @since 1.2.80
 * @return object
 */
function Fury() {
    
    return Theme::get_instance();
    
}

// Include the Fury theme setup class.
get_template_part( 'framework/classes/class-fury-setup' );

// Run setup.
Setup::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
