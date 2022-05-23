<?php 

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<?php get_header(); ?>

<div class="<?php fury_post_wrapper_class(); ?>">

    <?php if( have_posts() ): while( have_posts() ): the_post(); ?>

        <?php get_template_part( 'template-parts/content/content', get_post_format() ); ?>

    <?php endwhile; ?> 
    
        <?php get_template_part( 'template-parts/pagination' ); ?>
    
    <?php else: ?>

    <?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
