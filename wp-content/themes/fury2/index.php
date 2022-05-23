<?php 
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 */
    
// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<div class="<?php fury_post_wrapper_class(); ?>">

    <?php if( have_posts() ): while( have_posts() ): the_post(); ?>

        <?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>

    <?php endwhile; ?> 
    
        <?php get_template_part( 'template-parts/pagination' ); ?>
    
    <?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
