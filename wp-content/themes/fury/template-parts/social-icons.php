<?php
/**
 * Social Icons
 *
 * The Fury theme social icons template part.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 * @since 1.2.4 Updated the code.
 * @since 1.3.0 Updated the code.
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$icons = get_theme_mod( 'fury_social_icons', [
    [
        'media'  => 'rss',
        'url'    => esc_url_raw( get_bloginfo_rss( 'rss2_url' ) ),
        'target' => false
    ]
] );

$html = ''; 

if( ! empty( $icons ) ) {
    foreach( $icons as $icon ) {
        $html .= sprintf( 
            '<a href="%s" class="social-button sb-%s shape-none sb-dark" target="%s">' . 
            '<i class="socicon-%s"></i>' . 
            '</a>',
            esc_url( $icon['url'] ),
            esc_attr( $icon['media'] ),
            ! empty( $icon['target'] ) ? '_blank' : '_self',
            esc_attr( $icon['media'] )
        );
    }
}

echo ! empty( $html ) ? $html : '';
