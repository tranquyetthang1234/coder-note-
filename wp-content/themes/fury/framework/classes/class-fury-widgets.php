<?php
/**
 * Widgets
 *
 * The Fury widgets class.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 * @since 1.2.80 Updated the code.
 */

namespace Fury;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Widgets {
    
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
        
        add_action( 'widgets_init', [ $this, 'widgets_init' ] );
        
    }
    
    /**
     * Initialize
     *
     * Initialize the widgets.
     *
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function widgets_init() {
        register_sidebar( [
            'name'          => esc_html__( 'Main Sidebar', 'fury' ),
            'id'            => 'fury-sidebar',
            'description'   => esc_html__( 'Appears on posts & pages.', 'fury' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
        if( class_exists( 'woocommerce' ) ) {
            register_sidebar( [
                'name'          => esc_html__( 'Shop Sidebar', 'fury' ),
                'id'            => 'fury-shop-sidebar',
                'description'   => esc_html__( 'Appears on WooCommerce pages.', 'fury' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ] );
        }
        register_sidebar( [
            'name'          => esc_html__( 'Footer Widget 1', 'fury' ),
            'id'            => 'fury-footer-widget-1',
            'description'   => esc_html__( 'Appears on footer area.', 'fury' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s widget-light-skin">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
        register_sidebar( [
            'name'          => esc_html__( 'Footer Widget 2', 'fury' ),
            'id'            => 'fury-footer-widget-2',
            'description'   => esc_html__( 'Appears on footer area.', 'fury' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s widget-light-skin">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
        register_sidebar( [
            'name'          => esc_html__( 'Footer Widget 3', 'fury' ),
            'id'            => 'fury-footer-widget-3',
            'description'   => esc_html__( 'Appears on footer area.', 'fury' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s widget-light-skin">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
        register_sidebar( [
            'name'          => esc_html__( 'Footer Widget 4', 'fury' ),
            'id'            => 'fury-footer-widget-4',
            'description'   => esc_html__( 'Appears on footer area.', 'fury' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s widget-light-skin">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
        register_sidebar( [
            'name'          => esc_html__( 'Footer Widget 5', 'fury' ),
            'id'            => 'fury-footer-widget-5',
            'description'   => esc_html__( 'Appears on footer area.', 'fury' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s widget-light-skin">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
        register_sidebar( [
            'name'          => esc_html__( 'Footer Widget 6', 'fury' ),
            'id'            => 'fury-footer-widget-6',
            'description'   => esc_html__( 'Appears on footer area.', 'fury' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s widget-light-skin">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ] );
    }
    
}

Widgets::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
