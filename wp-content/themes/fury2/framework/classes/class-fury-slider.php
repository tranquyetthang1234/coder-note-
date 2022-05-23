<?php
/**
 * Slider
 *
 * The theme slider class.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.1.6
 * @since 1.2.80 Updated the code.
 */

namespace Fury;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include Fury slider abstract class.
get_template_part( 'framework/classes/abstract/class-fury-slider-defaults' );

if( ! class_exists( 'Fury\PRO\Plugin' ) ) {
    final class Slider extends \Fury_Slider_Defaults {

        /**
         * Class Constructor
         */
        function __construct() {

            parent::__construct();

        }

    }
    new Slider();
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
