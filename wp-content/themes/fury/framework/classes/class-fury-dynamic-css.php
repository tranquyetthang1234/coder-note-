<?php
/**
 * Dynamic CSS
 *
 * The theme dynamic css class.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 * @since 1.2.80 Updated the code.
 * @since 1.3.2 Updated the code.
 */

namespace Fury;

// Do not allow direct access to the file.
if (!defined('ABSPATH')) {
    exit;
}

class Dynamic_CSS
{

    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.2.80
     * @access public
     * @return null|object
     */
    public static $instance = null;

    /**
     * Get Instance
     *
     * Access the single instance of this class.
     *
     * @since 1.2.80
     * @access public
     * @return object
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Init
     *
     * Initialize the Agama theme inline style.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public static function init()
    {
        $css = '';
        $css .= self::header_top_bar();
        $css .= self::header();
        $css .= self::header_image();

        return apply_filters('fury/inline_css', $css);
    }

    /**
     * Header Top Bar
     *
     * The header top bar background colors.
     *
     * @since 1.3.7
     * @access private
     * @return mixed
     */
    private static function header_top_bar()
    {
        if (get_theme_mod('fury_htb_styling', true) &&
            get_theme_mod('fury_htb_bg_color_switch', 'gradient-color') == 'gradient-color') {
            $start = esc_attr(get_theme_mod('fury_htb_gradient_start_color', '#5540d9'));
            $end = esc_attr(get_theme_mod('fury_htb_gradient_end_color', '#ee2762'));
            $angle = esc_attr(get_theme_mod('fury_htb_gradient_angle', '90'));
            $css = '.topbar {';
            $css .= 'background-color:' . $start . ';';
            $css .= 'background-image:linear-gradient(' . $angle . 'deg, ' . $start . ' 0%, ' . $end . ' 100%)';
            $css .= '}';

            return $css;
        }
    }

    /**
     * Header
     *
     * The header background colors.
     *
     * @since 1.3.7
     * @access private
     * @return mixed
     */
    private static function header()
    {
        if (get_theme_mod('fury_header_styling', false) &&
            get_theme_mod('fury_header_bg_color_switch', 'gradient-color') == 'gradient-color') {
            $start = esc_attr(get_theme_mod('fury_header_gradient_start_color', '#5540d9'));
            $end = esc_attr(get_theme_mod('fury_header_gradient_end_color', '#ee2762'));
            $angle = esc_attr(get_theme_mod('fury_header_gradient_angle', '90'));
            $css = 'header.navbar, header.navbar .site-search {';
            $css .= 'background-color:' . $start . ';';
            $css .= 'background-image:linear-gradient(' . $angle . 'deg, ' . $start . ' 0%, ' . $end . ' 100%)';
            $css .= '}';
            $css .= 'header.navbar .site-search > input {';
            $css .= 'background-color:transparent;';
            $css .= '}';

            return $css;
        }
    }

    /**
     * Header Image
     *
     * The Fury theme header image dynamic css.
     *
     * @since 1.3.2
     * @access private
     * @return mixed
     */
    private static function header_image()
    {
        $header_image = esc_url(get_header_image());
        $overlay = esc_attr(get_theme_mod('fury_header_image_overlay', true));
        $background = get_theme_mod('fury_header_image_background_color', [
            'left' => 'rgba(85,64,217,0.8)',
            'right' => 'rgba(238,39,98,0.8)',
        ]);

        $background = array_map('esc_attr', $background);

        if ($header_image && $overlay) {
            // $css = "
            //     .header-image-wrapper .header-image {
            //         background-image: linear-gradient(to right, {$background['left']}, {$background['right']}), url({$header_image});
            //     }
            // ";
        } else
        if ($header_image && !$overlay) {
            // $css = "
            //     .header-image-wrapper .header-image {
            //         background-image: url({$header_image});
            //     }
            // ";
        } else {
            $css = '';
        }

        return $css;
    }

}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
