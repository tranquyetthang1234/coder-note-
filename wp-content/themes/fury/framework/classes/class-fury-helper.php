<?php
/**
 * Helper
 *
 * The theme helper class.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 * @since 1.2.80 Updated the code.
 */

namespace Fury;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Helper {

    /**
     * Plugin Active
     *
     * Check if called plugin is active.
     *
     * @param string $name (required) The plugin name.
     *
     * @since 1.2.5
     * @access public
     * @return bool
     */
    public static function is_plugin_active( $name ) {
        if( $name ) {
            if( ! is_admin() ) {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            }

            return is_plugin_active( $name );
        }
        return false;
    }

    /**
     * Social Share Enabled
     *
     * Checks if social share is enabled.
     *
     * @since 1.2.5
     * @access public
     * @return bool
     */
    public static function is_social_share_enabled() {
        global $post;

        // Get settings from customizer.
        $settings = get_theme_mod( 'fury_share_icons', [
            [
                'media'         => 'facebook'
            ],
            [
                'media'         => 'twitter'
            ],
            [
                'media'         => 'linkedin'
            ],
            [
                'media'         => 'rss'
            ]
        ] );

        // If there is found social share icons in customizer.
        if( ! empty( $settings ) ) {

            // If social share disabled thru meta box.
            if( 'off' == get_post_meta( $post->ID, '_fury_social_share', true ) ) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Get Post Tags
     *
     * @used in class-fury.php
     * @since 1.0
     */
    public static function get_tags() {
        if( has_tag() ) {
            $html = '<li>';
                $html .= '<i class="icon-tag"></i> ';
                foreach( get_the_tags() as $tag ) {
                    $tag_link = get_tag_link( $tag->term_id );

                    $html .= '<a href="'. esc_url( $tag_link ) .'" 
                                 title="'. esc_attr( $tag->name ) .' '. esc_attr__( 'Tag', 'fury' ) .'" 
                                 class="'. esc_attr( $tag->slug ) .'">';
                    $html .= esc_html( $tag->name ) .'</a>,';
                }
            $html .= '</li>';
            return $html;
        }
    }

    /**
     * Count Comments
     *
     * @used in class-fury.php
     * @since 1.0
     */
    public static function comments_count() {
        $comments = esc_html__( 'no comments', 'fury' );
        if( comments_open() ) {
            $comments = get_comments_number();
            if( $comments ) {
                $comments .= ' ' . esc_html__( 'comment', 'fury' );
            } else {
                $comments .= ' ' . esc_html__( 'comments', 'fury' );
            }
        }
        return $comments;
    }

}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
