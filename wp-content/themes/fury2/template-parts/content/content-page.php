<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if( has_post_thumbnail() ): ?>
    <!-- Post Thumbnail -->
    <div class="owl-carousel" data-owl-carousel='{ "nav": true," "dots": true, "loop": true }'>
        <figure>
            <?php the_post_thumbnail(); ?>
        </figure>
    </div><!-- Post Thumbnail End -->
    <?php endif; ?>

    <?php if( 'on' == fury_mod_title() ): ?>
        <h2><?php the_title(); ?></h2>
    <?php endif; ?>

    <?php the_content(); ?>

    <?php wp_link_pages( array( 'before' => '<kbd class="pages">' . esc_html__( 'Pages:', 'fury' ), 'after' => '</kbd>' ) ); ?>

    <div class="single-post-footer">
        
        <?php get_template_part( 'template-parts/social-share' ); ?>
        
    </div><!-- .single-post-footer -->
    
</article>
