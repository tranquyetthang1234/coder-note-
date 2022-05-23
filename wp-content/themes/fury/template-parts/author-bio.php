<?php
/**
 * Author Biography
 *
 * The Fury theme author biography template part.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.1.8
 * @since 1.3.0 Updated the code.
 */

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// If author biography disabled from customizer return early.
if( ! get_theme_mod( 'fury_author_bio', true ) ) {
    return;
}

$ID = get_the_author_meta( 'ID' );

if( get_the_author_meta( 'first_name') && get_the_author_meta( 'last_name' ) ) {
    $name = get_the_author_meta( 'first_name' ) .' '. get_the_author_meta( 'last_name' );
} else {
    $name = get_the_author_meta( 'display_name' );
}

$desc = nl2br( get_the_author_meta( 'description' ) );
$author_posts_url = get_author_posts_url( $ID, get_the_author_meta( 'user_nicename' ) );
$website = get_the_author_meta( 'user_url' ); ?>
    
<?php if( $desc ) : ?>
<section class="padding-top-2x" id="author">
    <h3 class="padding-bottom-1x"><?php esc_html_e( 'About Author', 'fury' ); ?></h3>
    <div class="comment even thread-even depth-1">
        <div class="comment-author-ava"><?php echo get_avatar( $ID, 50 ); ?></div>
        <div class="comment-body">
            <div class="comment-header">
                <h4 class="comment-title">
                    <a href="<?php echo esc_url( $author_posts_url ); ?>" title="<?php esc_attr_e( 'All posts by this author.', 'fury' ); ?>"><?php echo esc_html( $name ); ?></a>
                    <?php if( $website ) : ?>
                    <a href="<?php echo esc_url( $website ); ?>" title="<?php esc_attr_e( 'Author Website', 'fury' ); ?>" target="_blank" rel="nofollow"><i class="icon-link"></i></a>
                    <?php endif; ?>
                </h4>
            </div>
            <p class="comment-text">
                <?php echo fury_esc_author_bio( $desc ); ?>
            </p>
        </div>
    </div>
</section>
<?php endif; ?>
