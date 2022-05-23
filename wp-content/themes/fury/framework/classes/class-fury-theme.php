<?php

/**
 * Theme
 *
 * The Fury theme class.
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

final class Theme {
    
    /**
     * Development
     *
     * The development mode.
     * Meant to be used for cache busting purposes.
     *
     * @since 1.2.80
     * @access public
     * @return bool
     */
    private $development = false;
    
    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.0.0
     * @access public
     * @return null|object
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
     * Directory Path
     *
     * Retrieve theme directory DIR path.
     *
     * @param string $file (required) The theme file name.
     *
     * @since 1.2.80
     * @access public
     * @return string
     */
    public function DIR( $file = null ) {
        $path = wp_normalize_path( get_template_directory() . '/' );
        
        // Sanitize the file.
        if( ! empty( $file ) ) {
            $file = esc_attr( $file );
            $path = $path . wp_normalize_path( $file );
        }
        
        return $path;
    }
    
    /**
     * URI Path
     *
     * Retrieve theme directory URI path.
     *
     * @param string $file (optional) The theme file name.
     *
     * @since 1.2.80
     * @access public
     * @return string
     */
    public function URI( $file = null ) {
        $path   = get_template_directory_uri();
        $assets = get_template_directory_uri() . '/assets/';
        
        // Sanitize file name.
        if( ! empty( $file ) ) {
            $file = esc_attr( $file );
            $path = $assets . $file;
        }
        
        return esc_url( $path );
    }
    
    /**
     * Version
     *
     * Return the Fury theme version.
     *
     * @since 1.2.80
     * @access public
     * @return int
     */
    public function version() {
        $theme   = wp_get_theme();
        $version = $theme->get( 'Version' );
        
        if( $this->development ) {
            $version = uniqid();
        }
        
        return esc_attr( $version );
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
