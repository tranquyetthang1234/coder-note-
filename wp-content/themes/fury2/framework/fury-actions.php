<?php
/**
 * Actions
 *
 * The theme actions.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Fury\Helper;

/**
 * Custom jQuery Head
 *
 * @since 1.1.6
 */
if( ! function_exists( 'fury_custom_jquery_head' ) ) {
    function fury_custom_jquery_head() {
        $code = strip_tags( get_theme_mod( 'fury_custom_jquery_head', '' ) );
        
        $output  = '<script type="text/javascript">';
            $output .= $code;
        $output .= '</script>';
        
        echo $output;
    }
}
add_action( 'wp_head', 'fury_custom_jquery_head' );

/**
 * Theme Logo || Tag Line
 *
 * @since 1.0
 */
if( ! function_exists( 'fury_logo' ) ) {
    function fury_logo() {
        global $post;
        if( function_exists( 'the_custom_logo' ) ) {
            $meta = is_object( $post ) ? esc_attr( get_post_meta( $post->ID, '_fury_logo', true ) ) : '';
            if( $meta ) {
                $logo_url = wp_get_attachment_url( $meta );
                $logo  = '<a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" ';
                $logo .= 'class="custom-logo-link">';
                    $logo .= '<img src="'. esc_url( $logo_url ) .'" alt="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" class="custom-logo">';
                $logo .= '</a>';
                echo $logo;
            }
            else
            if( has_custom_logo() ) {
                the_custom_logo();
            } else {
                $logo  = '<a href="'. esc_url( home_url( '/' ) ) .'" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) .'" ';
                $logo .= 'class="custom-logo-link txt">';
                    $logo .= esc_attr( get_bloginfo( 'name', 'display' ) );
                    if( get_bloginfo( 'description' ) ) {
                        $logo .= '<span class="descr">'. esc_html( get_bloginfo( 'description', 'display' ) ) .'</span>';
                    }
                $logo .= '</a>';
                echo $logo;
            }
        } 
    }
}
add_action( 'fury_logo', 'fury_logo' );


/**
 * Theme Menu
 *
 * @since 1.0
 */
if( ! function_exists( 'fury_menu' ) ) {
    function fury_menu( $location = null ) {
        $args['container']      = false;
        $args['theme_location'] = $location;
        switch( $location ) {
            case 'fury-primary':
                $args['link_before'] = '<span>';
                $args['link_after']  = '</span>';
            break;
            case 'fury-offcanvas':
                $args['menu_class']  = 'menu';
                $args['menu_id']     = 'menu';
                $args['link_before'] = '';
                $args['link_after']  = '';
            break;
            case 'fury-mobile':
                $args['link_before'] = '';
                $args['link_after']  = '';
            break;
        }
        wp_nav_menu( $args );
    }
}
add_action( 'fury_menu', 'fury_menu' );


/**
 * Off-Canvas Menu
 *
 * @since 1.0
 */
if( ! function_exists( 'fury_off_canvas_menu' ) ) {
    function fury_off_canvas_menu( $location = null ) {
        if( class_exists( 'woocommerce' ) ) {
            $terms = get_terms( 'product_cat' );
            echo '<ul class="menu">';
            if ( $terms ) {
                foreach ( $terms as $term ) {
                    if( $term->parent == 0 ) {
                        $term_children = get_term_children( $term->term_id, 'product_cat' );
                        $has_children = ! empty( $term_children ) ? true : false;
                        $class = ! empty( $term_children ) ? ' class="has-children"' : '';
                        echo '<li'. $class .'>';
                            if( $has_children ) echo '<span>';
                                echo '<a href="'. esc_url( get_term_link( $term ) ) .'" class="'. esc_attr( $term->slug ) .'">';
                                    echo esc_html( $term->name );
                                echo '</a>';
                            if( $has_children ) echo '<span class="sub-menu-toggle"></span></span>';
                            if( $has_children ) {
                                echo '<ul class="offcanvas-submenu">';
                                    foreach( $term_children as $subcategory ) {
                                        $term = get_term_by( 'id', $subcategory, 'product_cat' );
                                        echo '<li><a href="'. esc_url( get_term_link( $subcategory, 'product_cat' ) ) .'">'. esc_html( $term->name ) .'</a></li>';
                                    }
                                echo '</ul>';
                            }
                        echo '</li>';
                    }
                }
            } else {
                echo '<li><a href="#">'. esc_html__( 'No Product Categories Found', 'fury' ) .'</a></li>';
            }
            echo '</ul>';
        } else { // Custom Menu
            do_action( 'fury_menu', 'fury-offcanvas' );
        }
    }
}
add_action( 'fury_off_canvas_menu', 'fury_off_canvas_menu' );


/**
 * Cart Dropdown
 *
 * @since 1.0
 */
if( ! function_exists( 'fury_cart_dropdown' ) ) {
    function fury_cart_dropdown() {
        global $woocommerce;
        
        $items      = $woocommerce->cart->get_cart();
        $currency   = get_woocommerce_currency_symbol();
        
        echo '<div class="toolbar-dropdown">';
            if( ! empty( $items ) ) {
                foreach( $items as $item => $values ) {
                    
                    $thumb      = wc_get_product( $values['product_id'] ); // Product Image
                    $_product   = wc_get_product( $values['data']->get_id() );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $values['product_id'], $values, $item );
                    $price      = $_product->get_price();
                    
                    $remove     = apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                        '<a href="%s" aria-label="%s" class="remove-from-cart" data-product_id="%s" data-product_sku="%s" data-cart_item_key="%s"><i class="icon-cross"></i></a>',
                        esc_url( wc_get_cart_remove_url( $item ) ),
                        esc_html__( 'Remove this item', 'fury' ),
                        esc_attr( $product_id ),
                        esc_attr( $_product->get_sku() ),
                        esc_attr( $item )
                    ), $item );
                    
                    echo '<div class="dropdown-product-item">';
                        echo '<span class="dropdown-product-remove">';
                            echo $remove;
                        echo '</span>';
                        echo '<a class="dropdown-product-thumb" href="'. esc_url( $_product->get_permalink() ) .'">';
                            echo $thumb->get_image();
                        echo '</a>';
                        echo '<div class="dropdown-product-info">';
                            echo '<a class="dropdown-product-title" href="'. esc_url( $_product->get_permalink() ) .'">';
                                echo esc_html( $_product->get_title() );
                            echo '</a>';
                            echo '<span class="dropdown-product-details">';
                                echo esc_attr( $values['quantity'] ) .' x '; 
                                echo esc_attr( $currency ) . esc_html( $price );
                            echo '</span>';
                        echo '</div>';
                    echo '</div>';
                }
                echo '<div class="toolbar-dropdown-group">';
                    echo '<div class="column">';
                        echo '<span class="text-lg">'. esc_html__( 'Total', 'fury' ) .':</span>';
                    echo '</div>';
                    echo '<div class="column text-right">';
                        echo '<span class="text-lg text-medium">'. esc_html( strip_tags( WC()->cart->get_cart_total() ) ) .'</span>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="toolbar-dropdown-group">';
                    echo '<div class="column">';
                        echo '<a a href="'. esc_url( wc_get_cart_url() ) .'" class="btn btn-sm btn-block btn-secondary">'. 
                            esc_html__( 'View Cart', 'fury' ) .'</a>';
                    echo '</div>';
                    echo '<div class="column">';
                        echo '<a href="'. esc_url( wc_get_checkout_url() ) .'" class="btn btn-sm btn-block btn-success">'. 
                            esc_html__( 'Checkout', 'fury' ) .'</a>';
                    echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="dropdown-product-item empty">';
                    esc_html_e( 'Cart is empty !', 'fury' );
                echo '</div>';
            }
        echo '</div>';
    }
}
add_action( 'fury_cart_dropdown', 'fury_cart_dropdown' );


/**
 * Header Image
 *
 * @since 1.0.4
 */
if( ! function_exists( 'fury_header_image' ) ) {
    function fury_header_image() {
        if( get_header_image() ) : ?>
            <div class="header-image-wrapper">
                <div class="header-image">
                    <div class="fury-divider divider-bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 458.89" preserveAspectRatio="none">
                            <path class="divider-fill" style="opacity:0.3" d="M394.87 433.4C488.07 402 572.38 322.71 656.53 241c-73.83 19-145.79 48.57-216.67 77.31-98.09 39.78-199.68 78.93-304.4 86.55 84.78 42.95 173.24 57.58 259.41 28.54zM656.53 241c45.78-11.75 92.27-19.4 139.69-20.19 70.57-1.16 138.4 12.7 203.78 36.37V0c-59.88 17.86-118.67 47.58-174.92 89.39C767.3 132.33 712 187.19 656.53 241zM135.46 404.86C88.86 381.25 43.38 349.08 0 310.9v82.75a378.35 378.35 0 0 0 81.63 12.23 485.13 485.13 0 0 0 53.83-1.02z"></path>
                            <path class="divider-fill" d="M1000 458.89V257.18c-65.38-23.67-133.21-37.53-203.78-36.37-47.42.79-93.91 8.44-139.69 20.19-84.15 81.71-168.46 161-261.66 192.4-86.17 29-174.63 14.41-259.41-28.54a485.13 485.13 0 0 1-53.83 1A378.35 378.35 0 0 1 0 393.65v65.24z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        <?php
        endif;
    }
}
add_action( 'fury_header_image', 'fury_header_image' );


/**
 * Theme Breadcrumb
 *
 * @since 1.0
 */
if( ! function_exists( 'fury_breadcrumb' ) ) {
    function fury_breadcrumb() {
        if( get_theme_mod( 'fury_breadcrumb_enable', false ) ) {
            get_template_part( 'framework/classes/class-fury-breadcrumb' );
            fury_breadcrumb_trail();
        }
    }
}
add_action( 'fury_breadcrumb', 'fury_breadcrumb' );


/**
 * Content Wrapper
 *
 * @since 1.0
 */
if( ! function_exists( 'fury_content_wrapper' ) ) {
    function fury_content_wrapper() {
        $row['class'] = '';
        
        if( 'none' == fury_mod_sidebar() ) {
            $row['class'] = esc_attr( ' justify-content-center' );
        }
        
        // Is WooCommerce Single Product Page.
        $single_product = false;
        if( class_exists( 'woocommerce' ) ) {
            if( is_product() ) {
                $single_product = true;
            }
        }
        
        // If is not full width template.
        if( ! is_page_template( 'templates/full-width.php' )  && ! is_page_template( 'templates/for-page-builders.php' ) ) {
            echo '<!-- Content Wrapper -->';
            echo '<div id="fury-content" class="content-wrapper container padding-bottom-3x clearfix">';
            
            // Do not output row if is 404 page or WooCommerce single product page.
            if( ! is_404() && ! $single_product ) {
                echo '<div class="row'. $row['class'] .'">';
            }
        }
    }
}
add_action( 'fury_content_wrapper', 'fury_content_wrapper' );


/**
 * Content Wrapper End
 *
 * @since 1.0
 */
if( ! function_exists( 'fury_content_wrapper_end' ) ) {
    function fury_content_wrapper_end() {
        if( ! is_404() ) {
            echo '</div><!-- Row End -->';
        }
        echo '</div><!-- Content Wrapper End -->';
    }
}
add_action( 'fury_content_wrapper_end', 'fury_content_wrapper_end' );

if( ! function_exists( 'fury_post_meta' ) ) :
    /**
     * Post Meta
     *
     * Render the post meta.
     *
     * @since 1.0.0
     * @since 1.3.0 Updated the code.
     */
    function fury_post_meta() {
        $author_id          = get_the_author_meta( 'ID' );
        $meta['date']       = esc_attr( get_theme_mod( 'fury_blog_meta_date', true ) );
        $meta['author']     = esc_attr( get_theme_mod( 'fury_blog_meta_author', true ) );
        $meta['tags']       = esc_attr( get_theme_mod( 'fury_blog_meta_tags', true ) );
        $meta['comments']   = esc_attr( get_theme_mod( 'fury_blog_meta_comments', true ) );
        
        $author_posts_url   = get_author_posts_url( $author_id, get_the_author_meta( 'user_nicename' ) );
        
        $class[] = 'col-md-3';
        
        if( 'left-sidebar' == fury_mod_sidebar() ) {
            $class[] = 'order-lg-2';
        }
        
        $class = apply_filters( 'fury_post_meta_wrapper_class', $class );
        $class = array_map( 'esc_attr', $class );
        $class = array_unique( $class );
        
        $html = '<div class="'. implode( ' ', $class ) .'">';
            $html .= '<ul class="post-meta">';
                if( $meta['date'] ) {
                    $html .= '<li><i class="icon-clock"></i> '. get_the_date() .'</li>';
                }
                if( $meta['author'] ) {
                    $html .= '<li>';
                        $html .= '<a href="'. esc_url( $author_posts_url ) .'">';
                            $html .= '<i class="icon-head"></i> '. ucfirst( get_the_author() );
                        $html .= '</a>';
                    $html .= '</li>';
                }
                if( $meta['tags'] ) {
                    $html .= Helper::get_tags();
                }
                if( $meta['comments'] ) {
                    $html .= '<li><a href="'. esc_url( get_the_permalink() ) .'#comments"><i class="icon-speech-bubble"></i> ';
                    $html .= Helper::comments_count() . '</a></li>';
                }
            $html .= '</ul>';
        $html .= '</div>';
        
        echo $html;
    }
endif;
add_action( 'fury_post_meta', 'fury_post_meta' );


/**
 * Single Post Tags
 *
 * @since 1.0
 */
if( ! function_exists( 'fury_post_tags' ) ) {
    function fury_post_tags() {
        if( has_tag() ) {
            $tags = get_the_tags();
            foreach( $tags as $tag ) {
                $comma = ',';
                if ( $tag === end( $tags ) ) {
                    $comma = '';
                }
                $tag_link = get_tag_link( $tag->term_id );
                $html  = "<a href='{$tag_link}' title='{$tag->name} Tag' class='sp-tag'>";
                $html .= "#{$tag->name}</a>{$comma} ";
                echo $html;
            }
        }
    }
}
add_action( 'fury_post_tags', 'fury_post_tags' );

/**
 * Comments Pagination
 *
 * @used in comments.php
 * @since 1.0
 */
if( ! function_exists( 'fury_comments_pagination' ) ) {
    function fury_comments_pagination() {
        if( get_previous_comments_link() || get_next_comments_link() ) {
            $html = '<nav class="pagination">';
                $html .= '<div class="column">';
                    $html .= get_previous_comments_link();
                $html .= '</div>';
                $html .= '<div class="column text-align-right">';
                    $html .= get_next_comments_link();
                $html .= '</div>';
            $html .= '</nav>';
            echo $html;
        }
    }
}
add_action( 'fury_comments_pagination', 'fury_comments_pagination' );

/**
 * Custom jQuery Footer
 *
 * @since 1.1.6
 */
if( ! function_exists( 'fury_custom_jquery_footer' ) ) {
    function fury_custom_jquery_footer() {
        $code = strip_tags( get_theme_mod( 'fury_custom_jquery_footer', '' ) );
        
        $output  = '<script type="text/javascript">';
            $output .= $code;
        $output .= '</script>';
        
        echo $output;
    }
}
add_action( 'wp_footer', 'fury_custom_jquery_footer' );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
