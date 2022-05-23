<?php
/**
 * The Template for displaying all single posts
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php get_header(); ?>

<div class="<?php fury_post_wrapper_class(); ?>">
    
    <?php while( have_posts() ): the_post(); ?>
    
        <?php get_template_part( 'template-parts/content/content', 'single' ); ?>
    
    <?php endwhile; ?>
    
    <?php
    
    // Posts navigation.
    get_template_part( 'template-parts/post-navigation' );
    
    // Author bio.
    get_template_part( 'template-parts/author-bio' );
    
    // Related articles.
    get_template_part( 'template-parts/related-articles' );
    
    // Comments
    comments_template(); ?>
    
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
