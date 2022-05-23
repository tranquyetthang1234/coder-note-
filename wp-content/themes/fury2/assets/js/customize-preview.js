/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 *
 * @since 1.3.2
 */

( function( $ ) {
    
    // Header image background overlay.
    wp.customize( 'fury_header_image_background_color', function( value ) {
        value.bind( function( color ) {
            var header_image = wp.customize.get().header_image;
            $('.header-image-wrapper .header-image').css({
                'background': 'linear-gradient(to right, '
                    .concat( color.left ).concat( ' 0, ' )
                    .concat( color.right ).concat( ' 100%), url('+ header_image +')' )
            });
        } );
    } );
    
})( jQuery );
