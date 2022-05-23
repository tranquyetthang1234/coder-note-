<?php
/**
 * WooCommerce
 *
 * The Fury WooCommerce class.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 * @since 1.2.80 Updated the code.
 * @since 1.3.1 Updated the code.
 */

namespace Fury;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// If WooCommerce not active, return early.
if( ! class_exists( 'WooCommerce' ) ) {
    return;
}
    
class WooCommerce {

    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.0.0
     * @access public
     * @var null|object
     */
    public static $instance = null;

    /**
     * Get Instance
     *
     * Access the single instance of this class.
     *
     * @since 1.0.0
     * @access public
     * @return object
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Class Constructor
     */
    function __construct() {
        global $woocommerce;

        // Dequeue WooCommerce Default Stylesheets
        add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

        // Enqueue Fury WooCommerce Stylesheet
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );

        // Remove Product via Dropdown Cart (Ajax)
        add_action( 'wp_ajax_product_remove', [ $this, 'ajax_product_remove' ] );
        add_action( 'wp_ajax_nopriv_product_remove', [ $this, 'ajax_product_remove' ] );

        // Header Cart Counter & Dropdown Toolbar
        if( version_compare( $woocommerce->version, '3.2.1', '>' ) ) {
            add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_counter_fragment' ] );
            add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_price_fragment' ] );
            add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'header_cart_dropdown_fragment' ] );
        } else {
            add_filter( 'add_to_cart_fragments', [ $this, 'header_cart_counter_fragment' ] );
            add_filter( 'add_to_cart_fragments', [ $this, 'header_cart_price_fragment' ] );
            add_filter( 'add_to_cart_fragments', [ $this, 'header_cart_dropdown_fragment' ] );
        }

        // Remove WooCommerce Wrappers
        remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
        remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

        // Add Fury Theme Wrappers
        add_action('woocommerce_before_main_content', [ $this, 'wrapper_start' ], 10 );
        add_action('woocommerce_after_main_content', [ $this, 'wrapper_end' ], 10 );

        // Remove WooCommerce Breadcrumb
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

        // Remove "Shop" Page Title
        add_filter( 'woocommerce_show_page_title', [ $this, 'hide_shop_title' ] );

        // Remove Default WooCommerce Sidebar & Attach Fury Shop Sidebar
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
        add_action( 'woocommerce_sidebar', [ $this, 'shop_sidebar' ], 10 );

        // Remove "Showing the Single Result"
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

        // Remove WooCommerce Order Dropdown
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        // Reorder OnSale
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 19 );

        // Add <a href Wrapper on Product Thumbs
        remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
        add_action( 'woocommerce_before_shop_loop_item', [ $this, 'product_thumb_link_open' ], 10 ); // Open href
        add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'product_thumb_link_close' ], 10 ); // Close href

        // Modify Product Loop Title
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
        add_action( 'woocommerce_shop_loop_item_title', [ $this, 'product_item_title' ] );

        // Remove WooCommerce Pagination
        remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );

        ########################################################################################
        # WOOCOMMERCE SINGLE PRODUCT PAGE
        ########################################################################################

        //  Share Icons
        add_action( 'woocommerce_share', [ $this, 'share_product' ] );

        // Disable Related Products Section
        if( ! get_theme_mod( 'fury_woocommerce_related_products', true ) ) {
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
        }

        // Output how many related products would show in how many columns
        add_filter( 'woocommerce_output_related_products_args', [ $this, 'related_products' ] );

        ########################################################################################
        # WOOCOMMERCE CART PAGE
        ########################################################################################
        add_action( 'woocommerce_before_cart', [ $this, 'before_cart' ], 10 );
        add_action( 'woocommerce_after_cart', [ $this, 'after_cart' ], 10 );
    }

    /**
     * Enqueue Scripts
     *
     * Enqueue scripts and styles for WooCommerce pages.
     *
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function wp_enqueue_scripts() {
        wp_enqueue_style( 
            'fury-woocommerce', 
            Fury()->URI( 'css/woocommerce.css' ), 
            [], 
            Fury()->version()
        );
    }

    /**
     * Is WooCommerce
     *
     * Check if we are on WooCommerce page.
     *
     * @since 1.0.7
     * @access private
     * @return bool
     */
    private function is_woocommerce_page() {
        if( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
            return true;
        }
    }

    /**
     * Hide Shop Title
     *
     * Hide the WooCommerce shop title.
     *
     * @since 1.0.0
     * @access public
     * @return bool
     */
    public function hide_shop_title() {
        return false;
    }

    /**
     * Wrapper Start
     *
     * Implement Fury start wrapper into WooCommerce pages.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function wrapper_start() {
        if( ! is_product() && is_active_sidebar( 'fury-shop-sidebar' ) ) {
            echo '<div class="col-xl-9 col-lg-8">';
        } else {
            echo '<div class="col-md-12">';
        }
    }

    /**
     * Wrapper End
     *
     * Implement Fury end wrapper into WooCommerce pages.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function wrapper_end() {
        if( ! is_product() ) {
            echo '</div>';
        }
    }

    /**
     * Shop Sidebar
     *
     * The shop sidebar.
     * 
     * @since 1.0.0
     * @access public
     * @return mixes
     */
    public function shop_sidebar() {
        echo '<div class="col-xl-3 col-lg-4">';
            echo '<aside class="sidebar sidebar-offcanvas">';
                dynamic_sidebar( 'fury-shop-sidebar' );
            echo '</div><!-- .sidebar.sidebar-offcanvas -->';
        echo '</div><!-- .col-xl-3.col-lg-4 -->';
    }

    /**
     * Thumb Link Open
     *
     * The product thumb link wrapper open.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function product_thumb_link_open() {
        echo '<a href="'. esc_url( get_permalink() ) .'" class="product-thumb">';
    }

    /**
     * Thumb Link Close
     *
     * The product thumb link wrapper close.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function product_thumb_link_close() {
        echo '</a>';
    }

    /**
     * Product Title
     *
     * The custom product item title.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function product_item_title() {
        $html = '<h3 class="product-title">';
            $html .= '<a href="'. esc_url( get_permalink() ) .'">'. get_the_title() .'</a>';
        $html .= '</h3>';
        echo $html;
    }

    /**
     * Before Cart Wraper
     *
     * Open a custom wrapper before cart wrapper.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function before_cart() {
        echo '<div class="table-responsive shopping-cart">';
    }

    /**
     * After Cart Wraper
     *
     * Open a custom wrapper after cart wrapper.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function after_cart() {
        echo '</div>';
    }

    /**
     * Share Product
     *
     * Display social share icons in single product content area.
     *
     * @since 1.0.0
     * @access public
     * @return mixed
     */
    public function share_product() {
        if( Helper::is_social_share_enabled() ) {
            echo '<hr class="margin-top-1x mb-3">';
            echo '<div class="entry-share mt-2 mb-2">';
                get_template_part( 'template-parts/social-share' );
            echo '</div>';
        }
    }

    /**
     * Related Products
     *
     * @param array $args (required) The related products arguments.
     *
     * @since 1.1.0
     * @access public
     * @return array
     */
    public function related_products( $args ) {
        $args['posts_per_page'] = 4;
        $args['columns'] = 1;

        return $args;
    }

    /**
     * Header Cart Counter
     *
     * The header cart counter.
     *
     * @param mixed $fragments (required) The cart counter fragments.
     *
     * @since 1.1.4
     * @access public
     * @return mixed
     */
    public function header_cart_counter_fragment( $fragments ) {
        global $woocommerce;

        ob_start(); ?>

        <span class="count">
            <?php echo sprintf( 
                _n( '%d', '%d', $woocommerce->cart->cart_contents_count, 'fury' ), 
                $woocommerce->cart->cart_contents_count 
            ); ?>
        </span>

        <?php $fragments['.cart span.count'] = ob_get_clean();

        return $fragments;
    }

    /**
     * Header Cart Price
     *
     * The header cart price fragment.
     *
     * @param mixed $fragments (required) The price fragments.
     *
     * @since 1.1.5
     * @access public
     * @return mixed
     */
    public function header_cart_price_fragment( $fragments ) {
        global $woocommerce;

        ob_start(); ?>

        <span class="subtotal">
            <?php echo esc_html( strip_tags( WC()->cart->get_cart_total() ) ); ?>
        </span>

        <?php $fragments['.cart span.subtotal'] = ob_get_clean();

        return $fragments;
    }

    /**
     * Cart Dropdown Contents
     *
     * The header cart dropdown contents.
     *
     * @param mixed $fragments (required) The fragments.
     *
     * @since 1.1.4
     * @access public
     * @return mixed
     */
    public function header_cart_dropdown_fragment( $fragments ) {
        global $woocommerce;

        ob_start();

        do_action( 'fury_cart_dropdown' );

        $fragments['.cart .toolbar-dropdown'] = ob_get_clean();

        return $fragments;
    }

    /**
     * Product Remove
     *
     * Remove product in the cart using Ajax.
     *
     * @since 1.1.4
     * @access public
     * @return mixed
     */
    public function ajax_product_remove() {
        // Get mini cart
        ob_start();

        foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            if( $cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] ) {
                WC()->cart->remove_cart_item( $cart_item_key );
            }
        }

        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();

        do_action( 'fury_cart_dropdown' );

        $cart_content = ob_get_clean();

        // Fragments and mini cart are returned
        $data = [
            'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', [
                    '.cart .toolbar-dropdown' => $cart_content
                ]
            ),
            'cart_hash' => apply_filters( 
                'woocommerce_add_to_cart_hash', 
                WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', 
                WC()->cart->get_cart_for_session() 
            )
        ];

        wp_send_json( $data );

        die();
    }

}

WooCommerce::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
