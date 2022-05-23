<?php
/**
 * Related Articles
 *
 * The Fury theme related articles template part.
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

// If related articles disabled trough customizer return early.
if( ! get_theme_mod( 'fury_blog_single_post_related_articles', true ) ) {
    return;
}

global $post;

$heading = esc_html( get_theme_mod( 'fury_blog_single_post_related_articles_h4', esc_html__( 'You May Also Like', 'fury' ) ) );

$categories = get_the_category( $post->ID );

if( $categories ) :

    $category_ids = array();

    foreach( $categories as $individual_category ) {
        $category_ids[] = $individual_category->term_id;
    }

    $args = array(
        'category__in'          => $category_ids,
        'post__not_in'          => array( $post->ID ),
        'posts_per_page'        => 3, // Number of related posts that will be shown.
        'ignore_sticky_posts'   => 1
    );

    $my_query = new wp_query( $args );

    if( $my_query->have_posts() ) :

        echo '<h3 class="padding-top-3x padding-bottom-1x">'. $heading .'</h3>'; ?>

        <div class="owl-carousel" data-owl-carousel='{"nav": false,"dots": true,"loop": true,"autoplay": true, "autoHeight": true,"margin": 30,"responsive": {"0":{"items":1},"630":{"items":2},"991":{"items":3},"1200":{"items":3}} }'><?php

            while( $my_query->have_posts() ) :
                $my_query->the_post(); ?>
                <div class="widget widget-featured-posts">
                    <div class="entry">

                        <?php if( has_post_thumbnail() ): ?>
                        <div class="entry-thumb">
                            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail( 'fury-related' ); ?>
                            </a>
                        </div>
                        <?php endif; ?>

                        <div class="entry-content">
                            <h4 class="entry-title">
                                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h4>
                            <span class="entry-meta"><?php echo ucfirst( get_the_author() ); ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php
    endif;
endif;

wp_reset_query(); ?>
