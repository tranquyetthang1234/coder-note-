<?php
// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include TGM Plugin Class
get_template_part( 'framework/library/tgm/class-tgm-plugin-activation' );

/**
 * Fury Plugin Installation
 *
 * @since 1.0.3
 * @since 1.3.1 Updated the code.
 */
function fury_tgmpa_register() {
    
    $plugins = [
        [
            'name'              => 'Fury Core',
            'slug'              => 'fury-core',
            'required'          => false,
            'force_activation'  => false
        ],
        [
            'name'              => 'Elementor',
            'slug'              => 'elementor',
            'required'          => false,
            'force_activation'  => false
        ]
    ];
    
    $goldaddons = [ 
        [
            'name'              => 'Gold Addons for Elementor',
            'slug'              => 'gold-addons-for-elementor',
            'required'          => false,
            'force_activation'  => false
        ] 
    ];
    
    // If Elementor Plugin Installed & Active
    if( is_plugin_active( 'elementor/elementor.php' ) ) {
        $plugins = array_merge( $plugins, $goldaddons );
    }
    
    // If Fury Pro Plugin Installed & Activated
    if( class_exists( 'Fury\PRO\Plugin' ) ) {
        $premium['layer_slider'] = [
            'name'              => 'Layer Slider',
            'slug'              => 'LayerSlider',
            'source'            => fury_generate_premium_plugin_uri( 'LayerSlider' ),
            'required'          => false,
            'force_activation'  => false
        ];
        
        $premium['rev_slider'] = [
            'name'              => 'Revolution Slider',
            'slug'              => 'revslider',
            'source'            => fury_generate_premium_plugin_uri( 'revslider' ),
            'required'          => false,
            'force_activation'  => false
        ];
        
        $plugins = array_merge( $plugins, $premium );
    }
    
	tgmpa( $plugins, [
		'id'           => 'fury_theme',
		'domain'       => 'fury',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true
	] );
}
add_action( 'tgmpa_register', 'fury_tgmpa_register' );

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
