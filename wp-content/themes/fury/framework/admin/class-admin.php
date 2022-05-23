<?php
/**
 * Admin
 *
 * The Fury theme admin class.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.3.2
 */

namespace Fury;

// No direct access allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Admin {
    
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
        
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
        
        $this->get_template_parts();
        
    }
    
    /**
     * Admin Scripts
     *
     * Enqueue a Fury theme backend styles and scripts.
     *
     * @since 1.2.3
     * @access public
     * @return void
     */
    public function admin_scripts() {
        if( has_action( 'fury/admin/before_enqueue_scripts' ) ) {
            /**
             * Hook: fury/admin/before_enqueue_scripts
             *
             * @hooked none
             *
             * @since 1.2.80
             */
            do_action( 'fury/admin/before_enqueue_scripts' );
        }
        
        // Admin Scripts
        wp_enqueue_script( 
            'fury-admin', 
            Fury()->URI( 'js/admin.js' ), 
            [ 'jquery' ], 
            Fury()->version()
        );
        
        if( has_action( 'fury/admin/after_enqueue_scripts' ) ) {
            /**
             * Hook: fury/admin/after_enqueue_scripts
             *
             * @hooked none
             *
             * @since 1.2.80
             */
            do_action( 'fury/admin/after_enqueue_scripts' );
        }
    }
    
    /**
     * Get Template Parts
     *
     * Include the Fury admin template parts.
     *
     * @since 1.3.2
     * @access private
     * @return void
     */
    private function get_template_parts() {
        if( is_admin() ) {
            get_template_part( 'framework/fury-plugin-activation' );
        }
        get_template_part( 'framework/admin/kirki/kirki' );
        get_template_part( 'framework/admin/modules/fury-upsell/class-customize' );
        get_template_part( 'framework/admin/class-customize-choices' );
        get_template_part( 'framework/admin/class-customize' );
    }
    
}

Admin::get_instance();
