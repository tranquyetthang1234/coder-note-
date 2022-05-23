<?php
/**
 * Pagination
 *
 * The Fury theme posts pagination template part.
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

global $wp_query;
        
$big        = 999999999;
$total      = $wp_query->max_num_pages;
$translated = esc_html__( 'Page', 'fury' );

if( get_query_var('paged') ) {
    $paged = get_query_var('paged');
}
elseif( get_query_var('page') ) {
    $paged = get_query_var('page');
} else { 
    $paged = 1; 
}

if( $total > 1 ) {
    echo '<nav class="pagination">';
        echo '<div class="column">';
            echo paginate_links( array(
                'base'                  => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'                => '?paged=%#%',
                'current'               => max( 1, $paged ),
                'total'                 => $total,
                'prev_next'             => false,
                'type'                  => 'list',
                'before_page_number'    => '<span class="screen-reader-text">' . $translated . '</span>'
            ) );
        echo '</div>';
        echo '<div class="column text-right hidden-xs-down">';
            $next = get_next_posts_link( esc_html__( 'Next', 'fury' ) . '<i class="icon-arrow-right"></i>' );
            $next = str_replace( 'href', 'class="btn btn-outline-secondary btn-sm" href', $next );
            echo $next;
        echo '</div>';
    echo '</nav>';
}
