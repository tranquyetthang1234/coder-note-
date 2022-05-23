<?php
/**
 * Server-side rendering of the `core/post-comments-form` block.
 *
 * @package WordPress
 */

/**
 * Renders the `core/post-comments-form` block on the server.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 * @return string Returns the filtered post comments form for the current post.
 */
function gutenberg_render_block_core_post_comments_form( $attributes, $content, $block ) {
	if ( ! isset( $block->context['postId'] ) ) {
		return '';
	}

	$classes = 'comment-respond'; // See comment further below.
	if ( isset( $attributes['textAlign'] ) ) {
		$classes .= 'has-text-align-' . $attributes['textAlign'];
	}

	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $classes ) );

	ob_start();
	comment_form( array(), $block->context['postId'] );
	$form = ob_get_clean();

	// We use the outermost wrapping `<div />` returned by `comment_form()`
	// which is identified by its default classname `comment-respond` to inject
	// our wrapper attributes. This way, it is guaranteed that all styling applied
	// to the block is carried along when the comment form is moved to the location
	// of the 'Reply' link that the user clicked by Core's `comment-reply.js` script.
	$form = str_replace( 'class="comment-respond"', $wrapper_attributes, $form );

	// Enqueue the comment-reply script.
	wp_enqueue_script( 'comment-reply' );

	return $form;
}

/**
 * Registers the `core/post-comments-form` block on the server.
 */
function gutenberg_register_block_core_post_comments_form() {
	register_block_type_from_metadata(
		__DIR__ . '/post-comments-form',
		array(
			'render_callback' => 'gutenberg_render_block_core_post_comments_form',
		)
	);
}
add_action( 'init', 'gutenberg_register_block_core_post_comments_form', 20 );

/**
 * Use the button block classes for the form-submit button.
 *
 * @param array $fields The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function gutenberg_post_comments_form_block_form_defaults( $fields ) {
	if ( wp_is_block_theme() ) {
		$fields['submit_button'] = '<input name="%1$s" type="submit" id="%2$s" class="%3$s wp-block-button__link" value="%4$s" />';
		$fields['submit_field']  = '<p class="form-submit wp-block-button">%1$s %2$s</p>';
	}

	return $fields;
}
add_filter( 'comment_form_defaults', 'gutenberg_post_comments_form_block_form_defaults' );
