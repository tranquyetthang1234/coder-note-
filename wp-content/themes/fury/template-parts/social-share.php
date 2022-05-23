<?php
/**
 * Social Share
 *
 * The Fury theme social share icons template part.
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

use Fury\Helper;

// If social share disabled, let's return early.
if( ! Helper::is_social_share_enabled() ) {
    return;
}

$share = get_theme_mod( 'fury_share_icons', [
    [
        'media' => 'facebook'
    ],
    [
        'media' => 'twitter'
    ],
    [
        'media' => 'linkedin'
    ],
    [
        'media' => 'rss'
    ]
] );

if( ! empty( $share ) ) {
    $html = '<div class="column">';
        $html .= '<div class="entry-share">';
            $html .= '<span class="text-muted">'. esc_html__( 'Share', 'fury' ) .'</span>';
            $html .= '<div class="share-links">';
            foreach( $share as $icon ) {
                if( 'email' == $icon['media'] ) {
                    $html .= sprintf(
                        '<a href="%s" class="social-button shape-circle sb-%s" data-toggle="tooltip" data-placement="top" data-original-title="%s" target="_blank">' . 
                        '<i class="socicon-%s"></i>' . 
                        '</a>',
                        'mailto:?&subject=' . esc_html( get_the_title() ) . '&body=' . esc_url( get_permalink() ),
                        esc_attr( 'mail' ),
                        esc_attr__( 'Email', 'fury' ),
                        esc_attr( 'mail' )
                    );
                }
                if( 'facebook' == $icon['media'] ) {
                    $html .= sprintf(
                        '<a href="%s" class="social-button shape-circle sb-%s" data-toggle="tooltip" data-placement="top" data-original-title="%s" target="_blank">' . 
                        '<i class="socicon-%s"></i>' . 
                        '</a>',
                        'https://www.facebook.com/sharer/sharer.php?u=' . esc_url( get_permalink() ),
                        esc_attr( $icon['media'] ),
                        esc_attr__( 'Facebook', 'fury' ),
                        esc_attr( $icon['media'] )
                    );
                }
                if( 'twitter' == $icon['media'] ) {
                    $html .= sprintf(
                        '<a href="%s" class="social-button shape-circle sb-%s" data-toggle="tooltip" data-placement="top" data-original-title="%s" target="_blank">' . 
                        '<i class="socicon-%s"></i>' . 
                        '</a>',
                        'https://twitter.com/intent/tweet?url=' . esc_url( get_permalink() ),
                        esc_attr( $icon['media'] ),
                        esc_attr__( 'Twitter', 'fury' ),
                        esc_attr( $icon['media'] )
                    );
                }
                if( 'linkedin' == $icon['media'] ) {
                    $html .= sprintf(
                        '<a href="%s" class="social-button shape-circle sb-%s" data-toggle="tooltip" data-placement="top" data-original-title="%s" target="_blank">' . 
                        '<i class="socicon-%s"></i>' . 
                        '</a>',
                        'https://www.linkedin.com/shareArticle?mini=true&url=' . esc_url( get_permalink() ),
                        esc_attr( $icon['media'] ),
                        esc_attr__( 'LinkedIn', 'fury' ),
                        esc_attr( $icon['media'] )
                    );
                }
                if( 'pinterest' == $icon['media'] ) {
                    $image_attributes = wp_get_attachment_image_src( get_the_ID() );
                    $image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ;
                    $html .= sprintf(
                        '<a href="%s" class="social-button shape-circle sb-%s" data-toggle="tooltip" data-placement="top" data-original-title="%s" target="_blank">' . 
                        '<i class="socicon-%s"></i>' . 
                        '</a>',
                        'https://pinterest.com/pin/create/button/?url=' . esc_url( get_permalink() ) . '&media=' . esc_url( $image_url ),
                        esc_attr( $icon['media'] ),
                        esc_attr__( 'Pinterest', 'fury' ),
                        esc_attr( $icon['media'] )
                    );
                }
                if( 'rss' == $icon['media'] ) {
                    $html .= sprintf(
                        '<a href="%s?feed=rss2&withoutcomments=1" class="social-button shape-circle sb-%s" data-toggle="tooltip" data-placement="top" data-original-title="%s" target="_blank">' . 
                        '<i class="socicon-%s"></i>' . 
                        '</a>',
                        esc_url( get_permalink() ),
                        esc_attr( $icon['media'] ),
                        esc_attr__( 'RSS', 'fury' ),
                        esc_attr( $icon['media'] )
                    );
                }
            }
            $html .= '</div>';
        $html .= '</div>';
    $html .= '</div>';
}

echo ! empty( $html ) ? $html : '';
