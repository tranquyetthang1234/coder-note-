<?php
/**
 * Customizer Choices
 *
 * Class with group of functions to extend customizer select fields.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.2.4
 * @since 1.2.80 Updated the code.
 */

namespace Fury\Customize;

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Choices {
    
    /**
     * Social Icons
     *
     * Holds list of social icons.
     *
     * @since 1.2.4
     * @access public
     * @return array
     */
    public static function socialIcons() {
        $social = [
            ''          => esc_attr__( '- Select -', 'fury' ),
            'facebook'  => esc_attr__( 'Facebook', 'fury' ),
            'twitter'   => esc_attr__( 'Twitter', 'fury' ),
            'youtube'   => esc_attr__( 'YouTube', 'fury' ),
            'instagram' => esc_attr__( 'Instagram', 'fury' ),
            'pinterest' => esc_attr__( 'Pinterest', 'fury' ),
            'rss'       => esc_attr__( 'RSS', 'fury' )
        ];
        
        /**
         * Filters the list of social icons.
         *
         * @param array $social An array of default social icons.
         *
         * @since 1.2.4
         */
        $social = apply_filters( 'fury/social_icons', $social );
        
        // Sanitize social icons.
        $social = array_map( 'esc_attr', $social );
        
        return $social;
    }
    
    /**
     * Social Share
     *
     * Hold list of social share icons.
     *
     * @since 1.2.4
     * @access public
     * @return array
     */
    public static function socialShare() {
        $share = [
            ''          => esc_attr__( '- Select -', 'fury' ),
            'facebook'  => esc_attr__( 'Facebook', 'fury' ),
            'twitter'   => esc_attr__( 'Twitter', 'fury' ),
            'linkedin'  => esc_attr__( 'LinkedIn', 'fury' ),
            'rss'       => esc_attr__( 'RSS', 'fury' )
        ];
        
        /**
         * Filters the list of share icons.
         *
         * @param array $share An array of default share icons.
         *
         * @since 1.2.4
         */
        $share = apply_filters( 'fury/share_icons', $share );
        
        // Sanitize share icons.
        $share = array_map( 'esc_attr', $share );
        
        return $share;
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
