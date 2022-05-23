<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="padding-top-3x col-lg-10 offset-lg-1">
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ( $product_tabs as $key => $product_tab ) : if( $key == 'description' ) {$class = ' active';}else{$class = '';} ?>
                <li class="nav-item">
                    <a class="nav-link<?php echo esc_attr( $class ); ?>" href="#tab-<?php echo esc_attr( $key ); ?>" data-toggle="tab" role="tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $product_tab['title'] ), $key ); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
        <?php foreach ( $product_tabs as $key => $product_tab ) : if( $key == 'description' ) {$class = ' show active';}else{$class = '';} ?>
            <div class="tab-pane fade<?php echo esc_attr( $class ); ?>" id="tab-<?php echo esc_attr( $key ); ?>">
                <?php if ( isset( $product_tab['callback'] ) ) { call_user_func( $product_tab['callback'], $key, $product_tab ); } ?>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

<?php endif; ?>
