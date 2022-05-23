<?php
/**
 * Customizer
 *
 * The theme customizer functions.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.0.0
 * @since 1.3.2 Updated the code.
 */

namespace Fury;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Kirki;
use Kirki_Helper;
use Fury\Customize\Choices;

class Customize {
    
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
        
        add_filter( 'kirki_telemetry', '__return_false' );
        add_filter( 'kirki_config', [ $this, 'kirki_config' ] );
        add_action( 'customize_preview_init', [ $this, 'preview_scripts' ] );
        add_action( 'customize_register', [ $this, 'customize_register' ] );
        
        $this->add_config();
        $this->add_panels();
        $this->add_sections();
        $this->add_fields();
        
    }
    
    /**
     * Kirki Config
     *
     * Configuration for the Kirki Customizer.
     * The function's argument is an array of existing config values
     * The function returns the array with the addition of our own arguments
     * and then that result is used in the kirki_config filter
     *
     * @param $config the configuration array
     *
     * @return array
     */
    public function kirki_config( $config ) {
        return wp_parse_args( array(
            'disable_loader' => true
        ), $config );
    }
    
    /**
	 * Preview Script
	 *
	 * Enqueue customize preview scripts.
	 *
	 * @since 1.3.2
	 * @access public
	 * return null
	 */
	public function preview_scripts() {
		wp_enqueue_script( 
            'fury-customize-preview', 
            Fury()->URI( 'js/customize-preview.js' ),
            [ 'customize-preview', 'customize-selective-refresh' ], 
            Fury()->version(), 
            true 
        );
	}
    
    /**
     * Customize Register
     *
     * @since 1.0.0
     * @since 1.3.2 Updated the code.
     * @access public
     * @return void
     */
    public function customize_register( $wp_customize ) {
        // Remove WordPress "Colors" Feature From Customizer
        $wp_customize->remove_section( 'colors' );
    
        // Remove WooCommerce "Columns" Feature From Customizer
        $wp_customize->remove_control( 'woocommerce_catalog_columns' );
    }
    
    /**
     * Add Config
     *
     * The Fury theme config add customize config.
     *
     * @since 1.0.0
     * @since 1.3.2 Updated the code.
     * @access private
     * @return void
     */
    private function add_config() {
        Kirki::add_config( 'fury_option', array(
            'capability'    => 'edit_theme_options',
            'option_type'   => 'theme_mod'
        ) );
    }
    
    /**
     * Add Panels
     *
     * The Fury theme add customize panels.
     *
     * @since 1.0.0
     * @since 1.3.2 Updated the code.
     * @access private
     * @return void
     */
    private function add_panels() {
        #################################################
        # GENERAL PANEL
        #################################################
        Kirki::add_panel( 'fury_general_panel', array(
            'title'     => esc_attr__( 'General', 'fury' ),
            'priority'  => 30
        ) );
        #############################################
        # LAYOUT
        #############################################
        Kirki::add_panel( 'fury_layout_panel', array(
            'title'     => esc_attr__( 'Layout', 'fury' ),
            'priority'  => 40
        ) );
        ################################################
        # HEADER
        ################################################
        Kirki::add_panel( 'fury_header_panel', array(
            'title'     => esc_attr__( 'Header', 'fury' ),
            'priority'  => 50
        ) );
        #############################################
        # NAVIGATIONS
        #############################################
        Kirki::add_panel( 'fury_navigations', array(
            'title'     => esc_attr__( 'Navigations', 'fury' ),
            'priority'  => 60
        ) );
        ####################################################
        # BREADCRUMB PANEL
        ####################################################
        Kirki::add_panel( 'fury_breadcrumb_panel', [
            'title'     => esc_attr__( 'Breadcrumb', 'fury' ),
            'priority'  => 70
        ] );
        ####################################################
        # SLIDER PANEL
        ####################################################
        Kirki::add_panel( 'fury_slider_panel', array(
            'title'     => esc_attr__( 'Slider', 'fury' ),
            'priority'  => 80
        ) );
        ##############################################
        # BLOG
        ##############################################
        Kirki::add_panel( 'fury_blog_panel', array(
            'title'     => esc_attr__( 'Blog', 'fury' ),
            'priority'  => 90
        ) );
        ################################################
        # FOOTER
        ################################################
        Kirki::add_panel( 'fury_footer_panel', array(
            'title'     => esc_attr__( 'Footer', 'fury' ),
            'priority'  => 120
        ) );
        #########################################################
        # FOOTER -> STYLING [SECTION]
        #########################################################
        Kirki::add_section( 'fury_footer_styling_section', array(
            'title' => esc_attr__( 'Styling', 'fury' ),
            'panel' => 'fury_footer_panel'
        ) );
    }
    
    /**
     * Add Sections
     *
     * The Fury theme add customize sections.
     *
     * @since 1.0.0
     * @since 1.3.2 Updated the code.
     * @access private
     * @return void
     */
    private function add_sections() {
        #######################################################
        # GENERAL -> BODY [SECTION]
        #######################################################
        Kirki::add_section( 'fury_general_body_section', array(
            'title' => esc_attr__( 'Body', 'fury' ),
            'panel' => 'fury_general_panel'
        ) );
        ########################################################
        # GENERAL -> EXTRA [SECTION]
        ########################################################
        Kirki::add_section( 'fury_general_extra_section', array(
            'title' => esc_attr__( 'Extra', 'fury' ),
            'panel' => 'fury_general_panel'
        ) );
        ########################################################
        # GENERAL -> PAGES [SECTION]
        ########################################################
        Kirki::add_section( 'fury_general_pages_section', array(
            'title' => esc_attr__( 'Pages', 'fury' ),
            'panel' => 'fury_general_panel'
        ) );
        ##########################################################
        # GENERAL -> STYLING [SECTION]
        ##########################################################
        Kirki::add_section( 'fury_general_styling_section', array(
            'title' => esc_attr__( 'Styling', 'fury' ),
            'panel' => 'fury_general_panel'
        ) );
        ###########################################################
        # GENERAL -> COMMENTS [SECTION]
        ###########################################################
        Kirki::add_section( 'fury_general_comments_section', array(
            'title' => esc_attr__( 'Comments', 'fury' ),
            'panel' => 'fury_general_panel'
        ) );
        #########################################################
        # LAYOUT -> GENERAL [SECTION]
        #########################################################
        Kirki::add_section( 'fury_layout_general_section', array(
            'title' => esc_attr__( 'General', 'fury' ),
            'panel' => 'fury_layout_panel'
        ) );
        #########################################################
        # HEADER -> TOP BAR [SECTION]
        #########################################################
        Kirki::add_section( 'fury_header_top_bar_section', array(
            'title' => esc_attr__( 'Top Bar', 'fury' ),
            'panel' => 'fury_header_panel'
        ) );
        #########################################################
        # HEADER -> GENERAL [SECTION]
        #########################################################
        Kirki::add_section( 'fury_header_general_section', array(
            'title' => esc_attr__( 'General', 'fury' ),
            'panel' => 'fury_header_panel'
        ) );
        ###########################################
        # HEADER -> LOGO [SECTION]
        ###########################################
        Kirki::add_section( 'title_tagline', array(
            'title' => esc_attr__( 'Logo', 'fury' ),
            'panel' => 'fury_header_panel'
        ) );
        ##########################################
        # HEADER -> HEADER IMAGE [SECTION]
        ##########################################
        Kirki::add_section( 'header_image', array(
            'title' => esc_attr__( 'Header Image', 'fury' ),
            'panel' => 'fury_header_panel'
        ) );
        ########################################################
        # NAVIGATIONS -> OFF-CANVAS NAVIGATION [SECTION]
        ########################################################
        Kirki::add_section( 'fury_nav_offcanvas_section', array(
            'title' => esc_attr__( 'Off-Canvas Navigation', 'fury' ),
            'panel' => 'fury_navigations'
        ) );
        ######################################################
        # NAVIGATIONS -> PRIMARY NAVIGATION [SECTION]
        ######################################################
        Kirki::add_section( 'fury_nav_primary_section', array(
            'title' => esc_attr__( 'Primary Navigation', 'fury' ),
            'panel' => 'fury_navigations'
        ) );
        ########################################################
        # BREADCRUMB -> GENERAL [SECTION]
        ########################################################
        Kirki::add_section( 'fury_breadcrumb_general_section', [
            'title' => esc_attr__( 'General', 'fury' ),
            'panel' => 'fury_breadcrumb_panel'
        ] );
        #############################################################
        # BREADCRUMB -> STYLING [SECTION]
        #############################################################
        Kirki::add_section( 'fury_breadcrumb_styling_section', array(
            'title' => esc_attr__( 'Styling', 'fury' ),
            'panel' => 'fury_breadcrumb_panel'
        ) );
        ####################################################
        # SLIDER -> GENERAL [SECTION]
        ####################################################
        Kirki::add_section( 'fury_slider_general_section', [
            'title' => esc_attr__( 'General', 'fury' ),
            'panel' => 'fury_slider_panel'
        ] );
        #########################################################
        # SLIDER -> SLIDE 1 [SECTION]
        #########################################################
        Kirki::add_section( 'fury_slider_slide_1_section', array(
            'title' => esc_attr__( 'Slide #1', 'fury' ),
            'panel' => 'fury_slider_panel'
        ) );
        #########################################################
        # SLIDER -> SLIDE 2 [SECTION]
        #########################################################
        Kirki::add_section( 'fury_slider_slide_2_section', array(
            'title' => esc_attr__( 'Slide #2', 'fury' ),
            'panel' => 'fury_slider_panel'
        ) );
        ###########################################################
        # BLOG -> SINGLE POST [SECTION]
        ###########################################################
        Kirki::add_section( 'fury_blog_single_post_section', array(
            'title' => esc_attr__( 'Single Post', 'fury' ),
            'panel' => 'fury_blog_panel'
        ) );
        #######################################################
        # BLOG -> POST META [SECTION]
        #######################################################
        Kirki::add_section( 'fury_blog_meta_section', array(
            'title' => esc_attr__( 'Post Meta', 'fury' ),
            'panel' => 'fury_blog_panel'
        ) );
        #######################################################
        # SOCIAL ICONS [SECTION]
        #######################################################
        Kirki::add_section( 'fury_social_icons_section', array(
            'title'    => esc_attr__( 'Social Icons', 'fury' ),
            'priority' => 80
        ) );
        #######################################################
        # SOCIAL SHARE [SECTION]
        #######################################################
        Kirki::add_section( 'fury_social_share_section', array(
            'title'     => esc_attr__( 'Social Share', 'fury' ),
            'priority'  => 90
        ) );
        ##############################################################
        # WOOCOMMERCE -> GENERAL [SECTION]
        ##############################################################
        Kirki::add_section( 'fury_woocommerce_general_section', array(
            'title'     => esc_attr__( 'General', 'fury' ),
            'panel'     => 'woocommerce',
            'priority'  => 1
        ) );
        #########################################################
        # FOOTER -> GENERAL [SECTION]
        #########################################################
        Kirki::add_section( 'fury_footer_general_section', array(
            'title' => esc_attr__( 'General', 'fury' ),
            'panel' => 'fury_footer_panel'
        ) );
    }
    
    /**
     * Add Fields
     *
     * The Fury theme add customize fields.
     *
     * @since 1.0.0
     * @since 1.3.2 Updated the code.
     * @access private
     * @return void
     */
    private function add_fields() {
        #######################################
        # GENERAL -> BODY [FIELDS]
        #######################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Body Font', 'fury' ),
            'tooltip'   => esc_attr__( 'Customize website body font.', 'fury' ),
            'settings'  => 'fury_body_font',
            'section'   => 'fury_general_body_section',
            'type'      => 'typography',
            'transport' => 'auto',
            'choices'   => array(
                'variant'   => array( 'standard', '500', '700', '900' )
            ),
            'default'   => array(
                'font-family'   => 'Maven Pro',
                'variant'       => 'regular',
                'font-size'     => '14px'
            ),
            'output'    => array(
                array(
                    'element' => 'body'
                )
            )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Body Background Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Customize body background color.', 'fury' ),
            'settings'  => 'fury_body_bg_color',
            'section'   => 'fury_general_body_section',
            'type'      => 'color',
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => 'body, div.offcanvas-wrapper',
                    'property'  => 'background-color'
                )
            ),
            'default'   => '#ffffff'
        ) );
        #######################################
        # GENERAL -> EXTRA [FIELDS]
        #######################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Custom jQuery Head', 'fury' ),
            'tooltip'   => esc_attr__( 'Add custom jQuery code into theme head area.', 'fury' ),
            'settings'  => 'fury_custom_jquery_head',
            'section'   => 'fury_general_extra_section',
            'type'      => 'code',
            'choices'   => array(
                'language' => 'js'
            )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Custom jQuery Footer', 'fury' ),
            'tooltip'   => esc_attr__( 'Add custom jQuery code into theme footer area.', 'fury' ),
            'settings'  => 'fury_custom_jquery_footer',
            'section'   => 'fury_general_extra_section',
            'type'      => 'code',
            'choices'   => array(
                'language' => 'js'
            )
        ) );
        #######################################
        # GENERAL -> PAGES [FIELDS]
        #######################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Page Title', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable page titles globally.', 'fury' ),
            'settings'  => 'fury_page_title',
            'section'   => 'fury_general_pages_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        #######################################
        # GENERAL -> STYLING [FIELDS]
        #######################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Primary Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select theme primary color.', 'fury' ),
            'settings'  => 'fury_primary_color',
            'section'   => 'fury_general_styling_section',
            'type'      => 'color',
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => '.btn-outline-primary',
                    'property'  => 'color'
                ),
                array(
                    'element'   => '.woocommerce .product-badge',
                    'property'  => 'background'
                ),
                array(
                    'element'   => '.btn-primary, .btn-primary:hover, .btn-outline-primary:hover, .list-group-item.active, .pagination .page-numbers > li.active > span',
                    'property'  => 'background-color'
                ),
                array(
                    'element'   => '.btn-outline-primary, .list-group-item.active, .pagination .page-numbers > li.active > span',
                    'property'  => 'border-color'
                )
            ),
            'default'   => '#0da9ef'
        ) );
        #######################################
        # GENERAL -> COMMENTS [FIELDS]
        #######################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Tags Suggestion', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable tags suggestion below comment form.', 'fury' ),
            'settings'  => 'fury_comments_tags_suggestion',
            'section'   => 'fury_general_comments_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        #######################################
        # LAYOUT -> GENERAL [FIELDS]
        #######################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Sidebar', 'fury' ),
            'tooltip'   => esc_attr__( 'Select sidebar type.', 'fury' ),
            'settings'  => 'fury_sidebar_layout',
            'section'   => 'fury_layout_general_section',
            'type'      => 'select',
            'choices'   => array(
                'right-sidebar' => esc_attr__( 'Right Sidebar', 'fury' ),
                'left-sidebar'  => esc_attr__( 'Left Sidebar', 'fury' ),
                'none'          => esc_attr__( 'No Sidebar', 'fury' )
            ),
            'default'   => 'right-sidebar'
        ) );
        #########################################################
        # HEADER -> TOP BAR [FIELDS]
        #########################################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Top Bar', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable header top bar feature.', 'fury' ),
            'settings'  => 'fury_header_top_bar',
            'section'   => 'fury_header_top_bar_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Email', 'fury' ),
            'tooltip'           => esc_attr__( 'Enter your contact email address.', 'fury' ),
            'settings'          => 'fury_header_top_bar_email',
            'section'           => 'fury_header_top_bar_section',
            'type'              => 'text',
            'default'           => 'johndoe@example.com',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_top_bar',
                    'operator'  => '==',
                    'value'     => true
                )
            )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Phone', 'fury' ),
            'tooltip'           => esc_attr__( 'Enter your contact phone number.', 'fury' ),
            'settings'          => 'fury_header_top_bar_phone',
            'section'           => 'fury_header_top_bar_section',
            'type'              => 'text',
            'default'           => '00 22 159 4421',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_top_bar',
                    'operator'  => '==',
                    'value'     => true
                )
            )
        ) );
        Kirki::add_field( 'fury_option', array(
            'type'        => 'custom',
            'settings'    => 'fury_htb_styling_separator',
            'section'     => 'fury_header_top_bar_section',
            'default'     => '<div style="border: 1px dashed #5e666e; padding: 30px; color: #555d66;">' . esc_html__( 'Enabe option below only if you want to customize header top bar styling.', 'fury' ) . '</div>',
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Custom Styling', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable top bar styling options.', 'fury' ),
            'settings'  => 'fury_htb_styling',
            'section'   => 'fury_header_top_bar_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'                 => esc_attr__( 'Background', 'fury' ),
            'tooltip'               => esc_attr__( 'Enable header topbar bacground color styling.', 'fury' ),
            'settings'              => 'fury_htb_bg_color_switch',
            'section'               => 'fury_header_top_bar_section',
            'type'                  => 'radio-buttonset',
            'choices'               => array(
                'background-color'  => esc_attr__( 'Backgroun Color', 'fury' ),
                'gradient-color'    => esc_attr__( 'Gradient Color', 'fury' )
            ),
            'active_callback'       => array(
                array(
                    'setting'       => 'fury_htb_styling',
                    'operator'      => '==',
                    'value'         => true
                )
            ),
            'default'               => 'gradient-color'
        ) );
        Kirki::add_field( 'fury_option', array(
            'tooltip'           => esc_attr__( 'Set header top bar custom background color.', 'fury' ),
            'settings'          => 'fury_htb_bg_color',
            'section'           => 'fury_header_top_bar_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_htb_styling',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_htb_bg_color_switch',
                    'operator'  => '==',
                    'value'     => 'background-color'
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.topbar',
                    'property'  => 'background-color'
                )
            ),
            'default'           => '#f5f5f5'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Start Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set gradient start color.', 'fury' ),
            'settings'          => 'fury_htb_gradient_start_color',
            'section'           => 'fury_header_top_bar_section',
            'type'              => 'color',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_htb_styling',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_htb_bg_color_switch',
                    'operator'  => '==',
                    'value'     => 'gradient-color'
                )
            ),
            'default'           => '#5540d9'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'End Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set gradient end color.', 'fury' ),
            'settings'          => 'fury_htb_gradient_end_color',
            'section'           => 'fury_header_top_bar_section',
            'type'              => 'color',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_htb_styling',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_htb_bg_color_switch',
                    'operator'  => '==',
                    'value'     => 'gradient-color'
                )
            ),
            'default'           => '#ee2762'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Angle', 'fury' ),
            'tooltip'           => esc_attr__( 'Set gradient angle.', 'fury' ),
            'settings'          => 'fury_htb_gradient_angle',
            'section'           => 'fury_header_top_bar_section',
            'type'              => 'slider',
            'choices'           => array(
                'min'           => '0',
                'max'           => '360',
                'step'          => '1'
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_htb_styling',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_htb_bg_color_switch',
                    'operator'  => '==',
                    'value'     => 'gradient-color'
                )
            ),
            'default'           => '90'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Links Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header top bar links/text color.', 'fury' ),
            'settings'          => 'fury_htb_links_color',
            'section'           => 'fury_header_top_bar_section',
            'transport'         => 'auto',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'output'            => array(
                array(
                    'element'   => '.topbar .topbar-column a, .topbar .topbar-column a:not(.social-button)',
                    'property'  => 'color'
                )
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_htb_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'   => 'rgba(255,255,255,0.72)'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Links Hover Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header top bar links/text hover color.', 'fury' ),
            'settings'          => 'fury_htb_links_hover_color',
            'section'           => 'fury_header_top_bar_section',
            'transport'         => 'auto',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'output'            => array(
                array(
                    'element'   => '.topbar .topbar-column a:not(.social-button):hover',
                    'property'  => 'color'
                )
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_htb_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'   => '#fff'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Top Bar Border Bottom', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header top bar border bottom color.', 'fury' ),
            'settings'          => 'fury_htb_border_bottom_color',
            'section'           => 'fury_header_top_bar_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_htb_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.topbar',
                    'property'  => 'border-bottom-color'
                )
            ),
            'default'           => 'rgba(255, 255, 255, 0.2)'
        ) );
        #########################################################
        # HEADER GENERAL [FIELDS]
        #########################################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Sticky Header', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable sticky header feature.', 'fury' ),
            'settings'  => 'fury_header_sticky',
            'section'   => 'fury_header_general_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Profile Icon', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable user profile icon on header right area.', 'fury' ),
            'settings'  => 'fury_header_profile',
            'section'   => 'fury_header_general_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Search Icon', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable search icon on header right area.', 'fury' ),
            'settings'  => 'fury_header_search',
            'section'   => 'fury_header_general_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        if( class_exists( 'woocommerce' ) ) {
            Kirki::add_field( 'fury_option', array(
                'label'     => esc_attr__( 'Cart Icon', 'fury' ),
                'tooltip'   => esc_attr__( 'Enable or disable cart icon in header right area.', 'fury' ),
                'settings'  => 'fury_header_cart_icon',
                'section'   => 'fury_header_general_section',
                'type'      => 'switch',
                'default'   => true
            ) );
        }
        Kirki::add_field( 'fury_option', array(
            'type'        => 'custom',
            'settings'    => 'fury_header_styling_separator',
            'section'     => 'fury_header_general_section',
            'default'     => '<div style="border: 1px dashed #5e666e; padding: 30px; color: #555d66;">' . esc_html__( 'Enabe option below only if you want to customize header styling.', 'fury' ) . '</div>',
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Custom Styling', 'fury' ),
            'tooltip'           => esc_attr__( 'Enable header styling options.', 'fury' ),
            'settings'          => 'fury_header_styling',
            'section'           => 'fury_header_general_section',
            'type'              => 'switch',
            'default'           => false
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'                 => esc_attr__( 'Background', 'fury' ),
            'tooltip'               => esc_attr__( 'Enable header bacground color styling.', 'fury' ),
            'settings'              => 'fury_header_bg_color_switch',
            'section'               => 'fury_header_general_section',
            'type'                  => 'radio-buttonset',
            'choices'               => array(
                'background-color'  => esc_attr__( 'Backgroun Color', 'fury' ),
                'gradient-color'    => esc_attr__( 'Gradient Color', 'fury' )
            ),
            'active_callback'       => array(
                array(
                    'setting'       => 'fury_header_styling',
                    'operator'      => '==',
                    'value'         => true
                )
            ),
            'default'               => 'gradient-color'
        ) );
        Kirki::add_field( 'fury_option', array(
            'tooltip'           => esc_attr__( 'Set header custom background color.', 'fury' ),
            'settings'          => 'fury_header_bg_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_header_bg_color_switch',
                    'operator'  => '==',
                    'value'     => 'background-color'
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => 'header.navbar',
                    'property'  => 'background-color'
                )
            ),
            'default'           => '#fff'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Start Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set gradient start color.', 'fury' ),
            'settings'          => 'fury_header_gradient_start_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_header_bg_color_switch',
                    'operator'  => '==',
                    'value'     => 'gradient-color'
                )
            ),
            'default'           => '#5540d9'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'End Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set gradient end color.', 'fury' ),
            'settings'          => 'fury_header_gradient_end_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_header_bg_color_switch',
                    'operator'  => '==',
                    'value'     => 'gradient-color'
                )
            ),
            'default'           => '#ee2762'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Angle', 'fury' ),
            'tooltip'           => esc_attr__( 'Set gradient angle.', 'fury' ),
            'settings'          => 'fury_header_gradient_angle',
            'section'           => 'fury_header_general_section',
            'type'              => 'slider',
            'choices'           => array(
                'min'           => '0',
                'max'           => '360',
                'step'          => '1'
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_header_bg_color_switch',
                    'operator'  => '==',
                    'value'     => 'gradient-color'
                )
            ),
            'default'           => '90'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Menu Links Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header navigation menu links color.', 'fury' ),
            'settings'          => 'fury_header_menu_links_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.site-menu ul:not(.sub-menu) > li > a',
                    'property'  => 'color'
                ),
                array(
                    'element'   => '.offcanvas-toggle, .toolbar .search, .toolbar .account, .toolbar .cart',
                    'property'  => 'color'
                ),
                array(
                    'element'   => 'header.navbar .site-search > input',
                    'property'  => 'color'
                ),
                array(
                    'element'   => 'header.navbar .site-search .search-tools .clear-search, header.navbar .site-search .search-tools .close-search',
                    'property'  => 'color'
                )
            ),
            'default'           => '#fff'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Menu Links Hover Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header navigation menu links hover color.', 'fury' ),
            'settings'          => 'fury_header_menu_links_hover_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.site-menu ul:not(.sub-menu) > li:hover > a',
                    'property'  => 'color'
                ),
                array(
                    'element'   => '.site-menu ul:not(.sub-menu) > li.active > a',
                    'property'  => 'color'
                ),
                array(
                    'element'   => '.site-menu ul:not(.sub-menu) > li.active > a',
                    'property'  => 'border-bottom-color'
                ),
                array(
                    'element'   => '.offcanvas-toggle:hover, header.navbar .site-search .search-tools .clear-search:hover, header.navbar .site-search .search-tools .close-search:hover',
                    'property'  => 'color'
                )
            ),
            'default'           => 'rgba(255,255,255,0.72)'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Sub-Menu Links Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header navigation sub-menu links color.', 'fury' ),
            'settings'          => 'fury_header_submenu_links_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.site-menu ul.sub-menu li a',
                    'property'  => 'color'
                )
            )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Sub-Menu Links Hover Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header navigation sub-menu links hover color.', 'fury' ),
            'settings'          => 'fury_header_submenu_links_hover_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.site-menu ul.sub-menu li a:hover',
                    'property'  => 'color'
                )
            )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Icons Link Hover Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header icons links hover color.', 'fury' ),
            'settings'          => 'fury_header_icons_link_hover_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.toolbar .search:hover, .toolbar .account:hover, .toolbar .cart:hover',
                    'property'  => 'color'
                )
            ),
            'default'           => 'rgba(255,255,255,0.72)'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Icons Hover Background Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header icons on hover background color.', 'fury' ),
            'settings'          => 'fury_header_icons_hover_bg_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.toolbar .search:hover, .toolbar .account:hover, .toolbar .cart:hover',
                    'property'  => 'background-color'
                )
            ),
            'default'           => 'rgba(255, 255, 255, 0.2)'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Header Borders Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header navigation canvas menu & icons border color.', 'fury' ),
            'settings'          => 'fury_header_borders_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => '.offcanvas-toggle',
                    'property'  => 'border-right-color'
                ),
                array(
                    'element'   => '.toolbar .search, .toolbar .account, .toolbar .cart',
                    'property'  => 'border-color'
                ),
                array(
                    'element'   => '.toolbar .cart > .subtotal',
                    'property'  => 'border-left-color'
                )
            ),
            'default'           => 'rgba(255, 255, 255, 0.2)'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Header Border Bottom Color', 'fury' ),
            'tooltip'           => esc_attr__( 'Set header border bottom color.', 'fury' ),
            'settings'          => 'fury_header_border_bottom_color',
            'section'           => 'fury_header_general_section',
            'type'              => 'color',
            'choices'           => array(
                'alpha'         => true
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'transport'         => 'auto',
            'output'            => array(
                array(
                    'element'   => 'header.navbar',
                    'property'  => 'border-bottom-color'
                )
            ),
            'default'           => 'rgba(255, 255, 255, 0.2)'
        ) );
        ###########################################
        # HEADER -> LOGO [FIELDS]
        ###########################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Site Title Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Set site title custom color.', 'fury' ),
            'settings'  => 'fury_header_logo_color',
            'section'   => 'title_tagline',
            'type'      => 'color',
            'transport' => 'auto',
            'choices'   => array(
                'alpha' => true
            ),
            'output'    => array(
                array(
                    'element'   => '.custom-logo-link',
                    'property'  => 'color'
                )
            ),
            'default'   => '#606975'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Logo Width', 'fury' ),
            'tooltip'   => esc_attr__( 'Set image logo width.', 'fury' ),
            'settings'  => 'fury_header_logo_width',
            'section'   => 'title_tagline',
            'type'      => 'slider',
            'choices'   => array(
                'min'   => 1,
                'max'   => 500,
                'step'  => 1
            ),
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => 'a.custom-logo-link',
                    'property'  => 'width',
                    'suffix'    => 'px'
                )
            ),
            'default'   => 154,
            'priority'  => 9
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Site Title Hover Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Set site title custom hover color.', 'fury' ),
            'settings'  => 'fury_header_logo_hover_color',
            'section'   => 'title_tagline',
            'type'      => 'color',
            'transport' => 'auto',
            'choices'   => array(
                'alpha' => true
            ),
            'output'    => array(
                array(
                    'element'   => '.custom-logo-link:hover',
                    'property'  => 'color'
                )
            ),
            'default'   => '#0da9ef'
        ) );
        ##########################################
        # HEADER -> HEADER IMAGE [FIELDS]
        ##########################################
        Kirki::add_field( 'fury_option', [
            'label'     => esc_attr__( 'Enable background color overlay?', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable the header image background color overlay.', 'fury' ),
            'settings'  => 'fury_header_image_overlay',
            'section'   => 'header_image',
            'type'      => 'checkbox',
            'default'   => true,
            'priority'  => 1
        ] );
        Kirki::add_field( 'fury_option', [
            'label'     => esc_attr__( 'Background Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select the header image background color.', 'fury' ),
            'settings'  => 'fury_header_image_background_color',
            'section'   => 'header_image',
            'type'      => 'multicolor',
            'transport' => 'postMessage',
            'choices'   => [
                'left'  => esc_attr__( 'Left', 'fury' ),
                'right' => esc_attr__( 'Right', 'fury' )
            ],
            'default'   => [
                'left'  => 'rgba(85,64,217,0.8)',
                'right' => 'rgba(238,39,98,0.8)'
            ],
            'active_callback'   => [
                [
                    'setting'   => 'fury_header_image_overlay',
                    'operator'  => '==',
                    'value'     => true
                ]  
            ],
            'priority'  => 1
        ] );
        ###############################################
        # NAVIGATIONS -> OFF-CANVAS NAVIGATION [FIELDS]
        ###############################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Enable Canvas Navigation', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable Offcanvas navigation on header left side.', 'fury' ),
            'settings'  => 'fury_header_offcanvas_menu',
            'section'   => 'fury_nav_offcanvas_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Canvas Open Background Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select off-canvas navigation wrapper background color.', 'fury' ),
            'settings'  => 'fury_header_offcanvas_menu_bg_color',
            'section'   => 'fury_nav_offcanvas_section',
            'type'      => 'color',
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => '.offcanvas-container',
                    'property'  => 'background-color'
                )
            ),
            'default'   => '#374250'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Links Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select off-canvas menu links color.', 'fury' ),
            'settings'  => 'fury_header_offcanvas_menu_links_color',
            'section'   => 'fury_nav_offcanvas_section',
            'type'      => 'color',
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => '.offcanvas-menu ul li a',
                    'property'  => 'color'
                )
            ),
            'default'   => '#fff'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Links Hover Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select off-canvas menu links hover color.', 'fury' ),
            'settings'  => 'fury_header_offcanvas_menu_links_hover_color',
            'section'   => 'fury_nav_offcanvas_section',
            'type'      => 'color',
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => '.offcanvas-menu ul li a:hover',
                    'property'  => 'color'
                )
            ),
            'default'   => '#0da9ef'
        ) );
        if( ! class_exists( 'Fury\PRO\Plugin' ) ) {
            Kirki::add_field( 'fury_option', [
                'type'        => 'custom',
                'settings'    => 'fury_offcanvas_nav_upsell',
                'section'     => 'fury_nav_offcanvas_section',
                'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                                 '<ul class="themevision-upsell-features">' . 
                                 '<li><span class="upsell-pro-label"></span> Font Family</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Font Variant</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Font Size</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Line Height</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Font Color</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Text Transform</li>' . 
                                 '</ul>' . 
                                 '</div>'
            ] );
        }
        ######################################################
        # NAVIGATIONS -> PRIMARY NAVIGATION [FIELDS]
        ######################################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Links Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select primary navigation links color.', 'fury' ),
            'settings'  => 'fury_nav_primary_links_color',
            'section'   => 'fury_nav_primary_section',
            'type'      => 'color',
            'transport' => 'auto',
            'choices'   => array(
                'alpha' => true
            ),
            'output'    => array(
                array(
                    'element'   => '.site-menu > ul > li > a',
                    'property'  => 'color'
                )
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => false
                )
            ),
            'default'   => '#606975'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Links Hover Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select primary navigation links hover color.', 'fury' ),
            'settings'  => 'fury_nav_primary_links_hover_color',
            'section'   => 'fury_nav_primary_section',
            'type'      => 'color',
            'transport' => 'auto',
            'choices'   => array(
                'alpha' => true
            ),
            'output'    => array(
                array(
                    'element'   => 'a.offcanvas-toggle:hover, .site-menu ul:not(.sub-menu) > li.active > a, .site-menu ul:not(.sub-menu) > li:hover > a',
                    'property'  => 'color'
                ),
                array(
                    'element'   => '.site-menu > ul > li.active > a',
                    'property'  => 'border-bottom-color'
                )
            ),
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_header_styling',
                    'operator'  => '==',
                    'value'     => false
                )
            ),
            'default'   => '#0da9ef'
        ) );
        if( ! class_exists( 'Fury\PRO\Plugin' ) ) {
            Kirki::add_field( 'fury_option', [
                'type'        => 'custom',
                'settings'    => 'fury_primary_nav_upsell',
                'section'     => 'fury_nav_primary_section',
                'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                                 '<ul class="themevision-upsell-features">' . 
                                 '<li><span class="upsell-pro-label"></span> Font Family</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Font Variant</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Font Size</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Line Height</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Font Color</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Text Transform</li>' . 
                                 '</ul>' . 
                                 '</div>'
            ] );
        }
        ##################################
        # BREADCRUMB -> GENERAL [FIELDS]
        ##################################
        Kirki::add_field( 'fury_option', [
            'label'     => esc_attr__( 'Enable breadcrumb site-wide ?', 'fury' ),
            'settings'  => 'fury_breadcrumb_enable',
            'section'   => 'fury_breadcrumb_general_section',
            'type'      => 'checkbox',
            'default'   => true
        ] );
        #######################################
        # BREADCRUMB -> STYLING [FIELDS]
        #######################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Background Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select breadcrumb background color.', 'fury' ),
            'settings'  => 'fury_breadcrumb_bg_color',
            'section'   => 'fury_breadcrumb_styling_section',
            'type'      => 'color',
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => '.page-title',
                    'property'  => 'background-color'
                )
            ),
            'default'   => '#f5f5f5'
        ) );
        if( ! class_exists( 'Fury\PRO\Plugin' ) ) {
            Kirki::add_field( 'fury_option', [
                'type'        => 'custom',
                'settings'    => 'fury_breadcrumb_upsell',
                'section'     => 'fury_breadcrumb_styling_section',
                'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                                 '<ul class="themevision-upsell-features">' . 
                                 '<li><span class="upsell-pro-label"></span> Background Gradient Color</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Background Image</li>' . 
                                 '</ul>' . 
                                 '</div>'
            ] );
        }
        ####################################################
        # SLIDER -> GENERAL [FIELDS]
        ####################################################
        Kirki::add_field( 'fury_option', [
            'label'     => esc_attr__( 'Enable', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable Fury slider.', 'fury' ),
            'settings'  => 'fury_slider_enable',
            'section'   => 'fury_slider_general_section',
            'type'      => 'switch',
            'default'   => false
        ] );
        Kirki::add_field( 'fury_option', [
            'label'     => esc_attr__( 'Enable on Pages', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable Fury slider on custom pages.', 'fury' ),
            'settings'  => 'fury_slider_on_pages',
            'section'   => 'fury_slider_general_section',
            'type'      => 'select',
            'multiple'  => 999,
            'choices'   => [], /* Unmark this code after WooComerce releases the update for the fatal error. Kirki_Helper::get_posts(
                [
                    'posts_per_page' => 10,
                    'post_type'      => 'page'
                ]
            )*/
        ] );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Background Image', 'fury' ),
            'tooltip'   => esc_attr__( 'Set custom slider background image.', 'fury' ),
            'settings'  => 'fury_slider_bg_image',
            'section'   => 'fury_slider_general_Section',
            'type'      => 'image',
            'default'   => Fury()->URI( 'img/slider-bg.jpg' )
        ) );
        #######################################
        # SLIDER -> SLIDE 1 [FIELDS]
        #######################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Enable', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable slide ?', 'fury' ),
            'settings'  => 'fury_slide_1_enable',
            'section'   => 'fury_slider_slide_1_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Slide Text', 'fury' ),
            'tooltip'   => esc_attr__( 'Add custom slide text.', 'fury' ),
            'settings'  => 'fury_slide_1_text',
            'section'   => 'fury_slider_slide_1_section',
            'type'      => 'editor',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_1_enable',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'   => esc_attr__( 'Learn more about Fury', 'fury' )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Slide Text Typography', 'fury' ),
            'tooltip'   => esc_attr__( 'Slider text customization.', 'fury' ),
            'settings'  => 'fury_slide_1_text_typo',
            'section'   => 'fury_slider_slide_1_section',
            'type'      => 'typography',
            'transport' => 'auto',
            'default'   => array(
                'font-family'       => 'inherit',
                'variant'           => 'regular',
                'font-size'         => '30px',
                'line-height'       => '1.2',
                'letter-spacing'    => '0',
                'color'             => '#606975',
                'text-transform'    => 'none',
                'text-align'        => 'left'
            ),
            'active_callback' => array(
                array(
                    'setting'   => 'fury_slide_1_enable',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'output'    => array(
                array(
                    'element' => '.hero-slider .slide-1 div.h2'
                )
            )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Slide Image', 'fury' ),
            'tooltip'   => esc_attr__( 'Set custom slide image.', 'fury' ),
            'settings'  => 'fury_slide_1_image',
            'section'   => 'fury_slider_slide_1_section',
            'type'      => 'image',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_1_enable',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default' => Fury()->URI( 'img/slide-image.png' )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Slider Button', 'fury' ),
            'tooltip'           => esc_attr__( 'Enable or disable slider button.', 'fury' ),
            'settings'          => 'fury_slide_1_button',
            'section'           => 'fury_slider_slide_1_section',
            'type'              => 'switch',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_1_enable',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'           => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Button URL', 'fury' ),
            'tooltip'           => esc_attr__( 'Set button custom url.', 'fury' ),
            'settings'          => 'fury_slide_1_button_url',
            'section'           => 'fury_slider_slide_1_section',
            'type'              => 'text',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_1_enable',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_slide_1_button',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'           => '#'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Button Title', 'fury' ),
            'tooltip'           => esc_attr__( 'Set button custom url.', 'fury' ),
            'settings'          => 'fury_slide_1_button_title',
            'section'           => 'fury_slider_slide_1_section',
            'type'              => 'text',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_1_enable',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_slide_1_button',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'           => esc_attr__( 'Learn More', 'fury' )
        ) );
        #########################################################
        # SLIDER -> SLIDE 2 [FIELDS]
        #########################################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Enable', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable slide ?', 'fury' ),
            'settings'  => 'fury_slide_2_enable',
            'section'   => 'fury_slider_slide_2_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Slide Text', 'fury' ),
            'tooltip'   => esc_attr__( 'Add custom slide text.', 'fury' ),
            'settings'  => 'fury_slide_2_text',
            'section'   => 'fury_slider_slide_2_section',
            'type'      => 'editor',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_2_enable',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'   => esc_attr__( 'Learn more about Fury', 'fury' )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Slide Text Typography', 'fury' ),
            'tooltip'   => esc_attr__( 'Slider text customization.', 'fury' ),
            'settings'  => 'fury_slide_2_text_typo',
            'section'   => 'fury_slider_slide_2_section',
            'type'      => 'typography',
            'transport' => 'auto',
            'default'   => array(
                'font-family'       => 'inherit',
                'variant'           => 'regular',
                'font-size'         => '30px',
                'line-height'       => '1.2',
                'letter-spacing'    => '0',
                'color'             => '#606975',
                'text-transform'    => 'none',
                'text-align'        => 'left'
            ),
            'active_callback' => array(
                array(
                    'setting'   => 'fury_slide_2_enable',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'output'    => array(
                array(
                    'element' => '.hero-slider .slide-2 div.h2'
                )
            )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Slide Image', 'fury' ),
            'tooltip'   => esc_attr__( 'Set custom slide image.', 'fury' ),
            'settings'  => 'fury_slide_2_image',
            'section'   => 'fury_slider_slide_2_section',
            'type'      => 'image',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_2_enable',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'   => Fury()->URI( 'img/slide-image.png' )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Slider Button', 'fury' ),
            'tooltip'           => esc_attr__( 'Enable or disable slider button.', 'fury' ),
            'settings'          => 'fury_slide_2_button',
            'section'           => 'fury_slider_slide_2_section',
            'type'              => 'switch',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_2_enable',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'           => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Button URL', 'fury' ),
            'tooltip'           => esc_attr__( 'Set button custom url.', 'fury' ),
            'settings'          => 'fury_slide_2_button_url',
            'section'           => 'fury_slider_slide_2_section',
            'type'              => 'text',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_2_enable',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_slide_2_button',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'           => '#'
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Button Title', 'fury' ),
            'tooltip'           => esc_attr__( 'Set button custom url.', 'fury' ),
            'settings'          => 'fury_slide_2_button_title',
            'section'           => 'fury_slider_slide_2_section',
            'type'              => 'text',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_slide_2_enable',
                    'operator'  => '==',
                    'value'     => true
                ),
                array(
                    'setting'   => 'fury_slide_2_button',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'           => esc_attr__( 'Learn More', 'fury' )
        ) );
        ###########################################################
        # BLOG -> SINGLE POST [FIELDS]
        ###########################################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Posts Title', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable single post titles globally.', 'fury' ),
            'settings'  => 'fury_blog_single_post_title',
            'section'   => 'fury_blog_single_post_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Author Biography', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable author biography section below post.', 'fury' ),
            'settings'  => 'fury_author_bio',
            'section'   => 'fury_blog_single_post_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Posts Navigation', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable single post prev/next navigation feature.', 'fury' ),
            'settings'  => 'fury_blog_single_post_nav',
            'section'   => 'fury_blog_single_post_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Related Articles', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable single post related articles feature.', 'fury' ),
            'settings'  => 'fury_blog_single_post_related_articles',
            'section'   => 'fury_blog_single_post_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'             => esc_attr__( 'Related Articles Heading', 'fury' ),
            'tooltip'           => esc_attr__( 'Enter custom title for Related Articles heading.', 'fury' ),
            'settings'          => 'fury_blog_single_post_related_articles_h4',
            'section'           => 'fury_blog_single_post_section',
            'type'              => 'text',
            'active_callback'   => array(
                array(
                    'setting'   => 'fury_blog_single_post_related_articles',
                    'operator'  => '==',
                    'value'     => true
                )
            ),
            'default'           => __( 'You May Also Like', 'fury' )
        ) );
        #######################################################
        # BLOG -> POST META [FIELDS]
        #######################################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Post Author', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable post meta author.', 'fury' ),
            'settings'  => 'fury_blog_meta_author',
            'section'   => 'fury_blog_meta_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Post Date', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable post meta date.', 'fury' ),
            'settings'  => 'fury_blog_meta_date',
            'section'   => 'fury_blog_meta_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Post Tags', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable post meta tags.', 'fury' ),
            'settings'  => 'fury_blog_meta_tags',
            'section'   => 'fury_blog_meta_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Post Comments', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable or disable post meta comments.', 'fury' ),
            'settings'  => 'fury_blog_meta_comments',
            'section'   => 'fury_blog_meta_section',
            'type'      => 'switch',
            'default'   => true
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Read More Custom Link Text', 'fury' ),
            'tooltip'   => esc_attr__( 'Change "Read More" link text with custom one.', 'fury' ),
            'settings'  => 'fury_blog_meta_read_more_custom',
            'section'   => 'fury_blog_meta_section',
            'type'      => 'text',
            'default'   => esc_attr__( 'Read More', 'fury' )
        ) );
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Read More Link Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select read more link color.', 'fury' ),
            'settings'  => 'fury_blog_meta_read_more_link_color',
            'section'   => 'fury_blog_meta_section',
            'type'      => 'color',
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => 'a.moretag',
                    'property'  => 'color'
                )
            ),
            'default'   => '#0da9ef'
        ) );
        #######################################################
        # SOCIAL ICONS [FIELDS]
        #######################################################
        Kirki::add_field( 'fury_option', [
            'label'                 => esc_attr__( 'Social Icons', 'fury' ),
            'type'                  => 'repeater',
            'section'               => 'fury_social_icons_section',
            'row_label'             => [
                'type'              => 'field',
                'value'             => esc_attr__( ' social media', 'fury' ),
                'field'             => 'media',
            ],
            'button_label'          => esc_attr__( 'Add new icon', 'fury' ),
            'settings'              => 'fury_social_icons',
            'default'               => [
                [
                    'media'         => 'rss',
                    'url'           => esc_url_raw( get_bloginfo_rss( 'rss2_url' ) ),
                    'target'        => false
                ]
            ],
            'choices'               => [
                'limit'             => count( Choices::socialIcons() ) - 1
            ],
            'fields'                => [
                'media'             => [
                    'type'          => 'select',
                    'label'         => esc_attr__( 'Social Media', 'fury' ),
                    'description'   => esc_attr__( 'Select social media icon.', 'fury' ),
                    'choices'       => Choices::socialIcons(),
                ],
                'url'               => [
                    'type'          => 'text',
                    'label'         => esc_attr__( 'Page URL', 'fury' ),
                    'description'   => esc_attr__( 'Enter social media page url.', 'fury' )
                ],
                'target'            => [
                    'type'          => 'checkbox',
                    'label'         => esc_attr__( 'Open in new tab ?', 'fury' ),
                    'default'       => false
                ]
            ]
        ] );
        if( ! class_exists( 'Fury\PRO\Plugin' ) ) {
            Kirki::add_field( 'fury_option', [
                'type'        => 'custom',
                'settings'    => 'fury_social_icons_upsell',
                'section'     => 'fury_social_icons_section',
                'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                                 '<ul class="themevision-upsell-features">' . 
                                 '<li><span class="upsell-pro-label"></span> Amazon</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Android</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Behance</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Bitbucket</li>' . 
                                 '<li><span class="upsell-pro-label"></span> BitCoin</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Delicious</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Deviantart</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Dropbox</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Dribbble</li>' .
                                 '<li><span class="upsell-pro-label"></span> Digg</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Email</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Flickr</li>' . 
                                 '<li><span class="upsell-pro-label"></span> GitHub</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Google</li>' . 
                                 '<li><span class="upsell-pro-label"></span> LinkedIn</li>' . 
                                 '<li><span class="upsell-pro-label"></span> PayPal</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Phone</li>' .
                                 '<li><span class="upsell-pro-label"></span> Pinterest</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Reddit</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Skype</li>' . 
                                 '<li><span class="upsell-pro-label"></span> SoundCloud</li>' .
                                 '<li><span class="upsell-pro-label"></span> Spotify</li>' . 
                                 '<li><span class="upsell-pro-label"></span> StackOverflow</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Steam</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Stumbleupon</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Telegrem</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Tumblr</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Twitch</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Vimeo</li>' . 
                                 '<li><span class="upsell-pro-label"></span> VK</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Yahoo</li>' . 
                                 '</ul>' . 
                                 '</div>'
            ] );
        }
        #######################################################
        # SOCIAL SHARE [FIELDS]
        #######################################################
        Kirki::add_field( 'fury_option', [
            'label'                 => esc_attr__( 'Social Share', 'fury' ),
            'type'                  => 'repeater',
            'section'               => 'fury_social_share_section',
            'row_label'             => [
                'type'              => 'field',
                'value'             => esc_attr__( ' social share', 'fury' ),
                'field'             => 'media',
            ],
            'button_label'          => esc_attr__( 'Add new share icon', 'fury' ),
            'settings'              => 'fury_share_icons',
            'default'               => [
                [
                    'media'         => 'facebook'
                ],
                [
                    'media'         => 'twitter'
                ],
                [
                    'media'         => 'linkedin'
                ],
                [
                    'media'         => 'rss'
                ]
            ],
            'choices'               => [
                'limit'             => count( Choices::socialShare() ) - 1
            ],
            'fields'                => [
                'media'             => [
                    'type'          => 'select',
                    'label'         => esc_attr__( 'Select Share Icon', 'fury' ),
                    'description'   => esc_attr__( 'Select social share icon.', 'fury' ),
                    'choices'       => Choices::socialShare(),
                ]
            ]
        ] );
        if( ! class_exists( 'Fury\PRO\Plugin' ) ) {
            Kirki::add_field( 'fury_option', [
                'type'        => 'custom',
                'settings'    => 'fury_social_share_upsell',
                'section'     => 'fury_social_share_section',
                'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                                 '<ul class="themevision-upsell-features">' . 
                                 '<li><span class="upsell-pro-label"></span> Pinterest Share</li>' . 
                                 '<li><span class="upsell-pro-label"></span> Email Share</li>' . 
                                 '</ul>' . 
                                 '</div>'
            ] );
        }
        ##################################
        # WOOCOMMERCE -> GENERAL [FIELDS]
        ##################################
        Kirki::add_field( 'fury_option', [
            'label'       => esc_html__( 'Shop Columns', 'fury' ),
            'tooltip'     => esc_html__( 'Select shop columns.', 'fury' ),
            'settings'    => 'fury_woocommerce_shop_columns',
            'section'     => 'fury_woocommerce_general_section',
            'type'        => 'select',
            'choices'     => [
                'cols-1'  => __( 'One Column', 'fury' ),
                'cols-2'  => __( 'Two Columns', 'fury' ),
                'cols-3'  => __( 'Three Columns', 'fury' ),
                'cols-4'  => __( 'Four Columns', 'fury' )
            ],
            'default'     => 'cols-3'
        ] );
        Kirki::add_field( 'fury_option', [
            'label'     => esc_attr__( 'Related Products', 'fury' ),
            'tooltip'   => esc_attr__( 'Enable WooCommerce related products section on single product page (bottom).', 'fury' ),
            'settings'  => 'fury_woocommerce_related_products',
            'section'   => 'fury_woocommerce_general_section',
            'type'      => 'switch',
            'default'   => true
        ] );
        #########################################################
        # FOOTER -> GENERAL [FIELDS]
        #########################################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Footer Copyright', 'fury' ),
            'tooltip'   => esc_attr__( 'Set custom footer copyright text.', 'fury' ),
            'settings'  => 'fury_footer_copyright',
            'section'   => 'fury_footer_general_section',
            'type'      => 'editor',
            'default'   => ''
        ) );
        #########################################################
        # FOOTER -> STYLING [FIELDS]
        #########################################################
        Kirki::add_field( 'fury_option', array(
            'label'     => esc_attr__( 'Background Color', 'fury' ),
            'tooltip'   => esc_attr__( 'Select custom footer background color.', 'fury' ),
            'settings'  => 'fury_footer_bg_color',
            'section'   => 'fury_footer_styling_section',
            'type'      => 'color',
            'transport' => 'auto',
            'output'    => array(
                array(
                    'element'   => '.site-footer',
                    'property'  => 'background-color'
                )
            ),
            'default'   => '#374250'
        ) );
    }
    
}

Customize::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
