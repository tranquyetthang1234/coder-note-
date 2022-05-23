<?php
/**
 * Setup
 *
 * The Fury theme setup class.
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

class Setup {
    
    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.3.2
     * @access public
     * @var null|object
     */
    public static $instance = null;
    
    /**
     * Get Instance
     *
     * Access the single instance of this class.
     *
     * @since 1.3.2
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
        
        // Hook Actions
        add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
        add_action( 'after_setup_theme', [ $this, 'fury_setup' ] );
        
        // Hook Filters
        add_filter( 'body_class', [ $this, 'body_class' ] );
        
        $this->get_template_parts();
        
        if( has_action( 'fury/loaded' ) ) {
            /**
             * Theme Loaded
             *
             * Initialize actions after theme fully loaded.
             *
             * @since 1.2.5
             */
            do_action( 'fury/loaded' );
        }
    }
    
    /**
     * Enqueue Scripts
     *
     * Enqueue a Fury theme styles and scripts.
     *
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function wp_enqueue_scripts() {
        if( has_action( 'fury/before_enqueue_scripts' ) ) {
            /**
             * Hook: fury/before_enqueue_scripts
             *
             * @hooked none
             *
             * @since 1.2.80
             */
            do_action( 'fury/before_enqueue_scripts' );
        }
        
        if ( is_singular() ) {
            wp_enqueue_script( "comment-reply" );
        }
        
        // Bootstrap Script
        wp_enqueue_style( 
            'fury-bootstrap', 
            Fury()->URI( 'css/bootstrap.min.css' ), 
            [], 
            Fury()->version() 
        );
        
        // Theme Stylesheet
        wp_enqueue_style( 
            'fury', 
            get_stylesheet_uri(), 
            [], 
            Fury()->version()
        );
        
        wp_add_inline_style( 'fury', Dynamic_CSS::init() );
        
        // Modernizr Script
        wp_enqueue_script( 
            'fury-modernizr', 
            Fury()->URI( 'js/modernizr.min.js' ), 
            [], 
            Fury()->version()
        );
        
        // Vendor Scripts
        wp_enqueue_script( 
            'fury-vendor', 
            Fury()->URI( 'js/vendor.min.js' ), 
            [], 
            Fury()->version(), 
            true 
        );
        
        // Fury Scripts
        wp_enqueue_script( 
            'fury-scripts', 
            Fury()->URI( 'js/scripts.js' ), 
            [], 
            Fury()->version(), 
            true 
        );
        
        // Fury Functions Script
        wp_enqueue_script( 
            'fury-functions', 
            Fury()->URI( 'js/functions.min.js' ), 
            [ 'jquery' ], 
            Fury()->version()
        );
        
        if( has_action( 'fury/after_enqueue_scripts' ) ) {
            /**
             * Hook: fury/after_enqueue_scripts
             *
             * @hooked none
             *
             * @since 1.2.80
             */
            do_action( 'fury/after_enqueue_scripts' );
        }
    }
    
    /**
     * Theme Setup
     *
     * Setup the Fury theme.
     *
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function fury_setup() {
        
        if ( ! isset( $content_width ) ) {
            $content_width = 1170;
        }
        
        /*
         * Make theme available for translation.
         * Translations can be filed at WordPress.org.
         * 
         * @link https://translate.wordpress.org/projects/wp-themes/fury
         */
        load_theme_textdomain( 'fury', Fury()->DIR( 'languages' ) );
        
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );
        
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();
        
        // Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
        add_theme_support( 'post-formats', [ 'aside', 'gallery' ] );
        
        // Add custom logo support.
        $cl_defaults = [
            'height'      => 88,
            'width'       => 258,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => [ 'site-title', 'site-description' ]
        ];
        add_theme_support( 'custom-logo', $cl_defaults );
        
        // This theme uses post thumbnails.
        add_theme_support( 'post-thumbnails' );
        
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
        
        // Default Menus
        $menus = [
            'fury-primary'   => esc_html__( 'Primary Menu', 'fury' ),
            'fury-mobile'    => esc_html__( 'Mobile Menu', 'fury' )
        ];
        
        // If WooCommerce Not Active
        if( ! class_exists( 'woocommerce' ) ) {
            $menus = array_merge( $menus, 
                [ 'fury-offcanvas' => esc_html__( 'Off-Canvas Menu', 'fury' ) ]
            );
        }
        
        // Register Menus
        register_nav_menus( $menus );
        
        $custom_header_args = [
            'default-image'          => '%2$s/assets/img/header-image.jpg',
            'default-text-color'     => '515151',
            'height'                 => 400,
            'width'                  => 1920,
            'max-width'              => 2000,
            'flex-height'            => true,
            'flex-width'             => true,
            'random-default'         => false,
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => ''
        ];

        add_theme_support( 'custom-header', $custom_header_args );
        
        /**
         * Register a selection of default headers to be displayed by the custom header admin UI.
         *
         * @link https://developer.wordpress.org/reference/functions/register_default_headers/
         */
        register_default_headers( [
            'mountain' => [
                'url'           => '%2$s/assets/img/header-image.jpg',
                'thumbnail_url' => '%2$s/assets/img/header-image.jpg',
                'description'   => esc_html__( 'Header Image', 'fury' )
            ]
        ] );
        
        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );
        
        // Add WooCommerce Support
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
        
        // Add Custom Image Sizes
        add_image_size( 'fury-related', 100, 100, true ); // Related Articles (Single Post)
        
    }
    
    /**
     * Body Class
     *
     * Filter a body class WP function.
     *
     * @since 1.0.3
     * @access public
     * @return array
     */
    public function body_class( $classes ) {
        if( class_exists( 'woocommerce' ) && is_account_page() && ! is_user_logged_in() ) {
            $classes[] = 'woocommerce-login-page';
        }
        return $classes;
    }
    
    /**
     * Get Template Parts
     *
     * Load the Fury theme template parts.
     *
     * @since 1.0.0
     * @access private
     * @return void
     */
    private function get_template_parts() {
        if( has_action( 'fury/before_files_loaded' ) ) {
            /**
             * Hook: fury/before_files_loaded
             *
             * @hooked none
             *
             * @since 1.2.80
             */
            do_action( 'fury/before_files_loaded' );
        }
        
        get_template_part( 'framework/admin/class-admin' );
        get_template_part( 'framework/classes/class-fury-dynamic-css' );
        get_template_part( 'framework/classes/class-fury-helper' );
        get_template_part( 'framework/classes/class-fury-widgets' );
        get_template_part( 'framework/classes/class-fury-woocommerce' );
        get_template_part( 'framework/classes/class-fury-slider' );
        get_template_part( 'framework/fury-functions' );
        get_template_part( 'framework/fury-actions' );
        get_template_part( 'framework/fury-filters' );
        
        if( has_action( 'fury/after_files_loaded' ) ) {
            /**
             * Hook: fury/after_files_loaded
             *
             * @hooked none
             *
             * @since 1.2.80
             */
            do_action( 'fury/after_files_loaded' );
        }
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
