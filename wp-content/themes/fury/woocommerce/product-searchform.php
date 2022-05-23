<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form class="input-group form-group" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    
    <span class="input-group-btn">
        <button type="submit"><i class="icon-search"></i></button>
    </span>
    
    <input name="s" class="form-control" type="search" placeholder="<?php esc_attr_e( 'Search Product', 'fury' ); ?>" value="<?php echo get_search_query() ?>" title="<?php echo esc_attr_x( 'Search for:', 'Search for', 'fury' ) ?>" />
    
    <input type="hidden" name="post_type" value="product" />
    
</form>
