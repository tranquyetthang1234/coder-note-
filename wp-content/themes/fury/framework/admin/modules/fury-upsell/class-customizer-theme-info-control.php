<?php
/**
 * Fury Upsell Theme Info
 *
 * Fury upsell theme info class.
 *
 * @package Theme Vision
 * @subpackage Fury
 * @since 1.1.6
 * @since 1.2.80 Updated the code.
 */

namespace Fury\Admin\Customize;

// Exit if accessed directly.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 *  Fury Upsell Theme Info Class
 *
 * @package ThemeVision
 * @subpackage Fury
 */
if ( ! class_exists( __NAMESPACE__ . 'Upsell_Theme_Info' ) ) :

	/**
	 * Fury_Control_Upsell_Theme_Info class.
	 */
	class Upsell_Theme_Info extends \WP_Customize_Control {

		/**
		 * Control type
		 *
		 * @var string control type
		 */
		public $type = 'themevision-control-upsell';

		/**
		 * Button text
		 *
		 * @var string button text
		 */
		public $button_text = '';

		/**
		 * Button link
		 *
		 * @var string button url
		 */
		public $button_url = '#';

		/**
		 * List of features
		 *
		 * @var array theme features / options
		 */
		public $options = array();

		/**
		 * List of explanations
		 *
		 * @var array additional info
		 */
		public $explained_features = array();

		/**
		 * Fury_Control_Upsell_Theme_Info constructor.
		 *
		 * @param WP_Customize_Manager $manager the customize manager class.
		 * @param string               $id id.
		 * @param array                $args customizer manager parameters.
		 */
		public function __construct( \WP_Customize_Manager $manager, $id, array $args ) {
			$this->button_text;
			$manager->register_control_type( __NAMESPACE__ . '\Upsell_Theme_Info' );
			parent::__construct( $manager, $id, $args );
		}
        
		/**
		 * Enqueue resources for the control
		 */
		public function enqueue() {
			wp_enqueue_style( 
                'themevision-upsell-style', 
                Fury()->URI() . 'framework/admin/modules/fury-upsell/css/style.css', 
                Fury()->version() 
            );
		}

		/**
		 * Json conversion
		 */
		public function to_json() {
			parent::to_json();
			$this->json['button_text']        = $this->button_text;
			$this->json['button_url']         = $this->button_url;
			$this->json['options']            = $this->options;
			$this->json['explained_features'] = $this->explained_features;
		}

		/**
		 * Control content
		 */
		public function content_template() {
			?>
			<div class="themevision-upsell">
				<# if ( data.options ) { #>
					<ul class="themevision-upsell-features">
						<# for (option in data.options) { #>
							<li><span class="upsell-pro-label"></span>{{ data.options[option] }}
							</li>
							<# } #>
					</ul>
					<# } #>

						<# if ( data.button_text && data.button_url ) { #>
							<a target="_blank" href="{{ data.button_url }}" class="button button-primary" target="_blank">{{
								data.button_text }}</a>
							<# } #>

								<# if ( data.explained_features.length > 0 ) { #>
									<hr />

									<ul class="themevision-upsell-feature-list">
										<# for (requirement in data.explained_features) { #>
											<li>* {{{ data.explained_features[requirement] }}}</li>
											<# } #>
									</ul>
									<# } #>
			</div>
		<?php
		}
	}
endif;

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
