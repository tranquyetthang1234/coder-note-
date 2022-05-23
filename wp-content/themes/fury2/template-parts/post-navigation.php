<?php
/**
 * Post Navigation
 *
 * The Fury theme post navigation template part.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 * @since 1.3.0 Updated the code.
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// If post navigation disabled from customizer return early.
if( ! get_theme_mod( 'fury_blog_single_post_nav', true ) ) {
    return;
} ?>

<div class="entry-navigation">
    <div class="column text-left">
        <?php previous_post_link( '%link', '<i class="fa fa-angle-left"></i> ' . esc_html__( 'Prev', 'fury' ) ); ?>
    </div>
    <div class="column">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline-secondary view-all" data-toggle="tooltip" data-placement="top" data-original-title="<?php esc_attr_e( 'Home', 'fury' ); ?>"><i class="icon-menu"></i></a>
    </div>
    <div class="column text-right">
        <?php next_post_link( '%link', esc_html__( 'Next', 'fury' ) . ' <i class="fa fa-angle-right"></i>' ); ?>
    </div>
</div><!-- .entry-navigation -->
