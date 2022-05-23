<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    
    <!-- Meta Character Encoding -->
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    
    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Relationships Meta Data Profile -->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    
    <!-- Pingback -->
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
    <?php wp_head(); ?>
    
</head>
<body <?php body_class(); ?>>
    
    <?php
    
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }
    
    $user_info          = get_userdata( get_current_user_id() );
    $user_profile_url   = class_exists( 'woocommerce' ) ? wc_get_endpoint_url( 'my-account' ) : get_edit_user_link();
    $username           = is_user_logged_in() ? esc_html( ucfirst( $user_info->user_login ) ) : esc_html__( 'Guest', 'fury' );
    $email              = is_user_logged_in() ? esc_html( $user_info->user_email ) : esc_html__( 'Welcome Guest', 'fury' ); 
    $login_txt          = is_user_logged_in() ? esc_html__( 'Logout', 'fury' ) : esc_html__( 'Login', 'fury' ); 
    
    // WooCommerce Login
    if( ! is_user_logged_in() && class_exists( 'Woocommerce' ) ) {
        $login_url = esc_url( wc_get_page_permalink( 'myaccount' ) );
    }
    else // WordPress Login
    if( ! is_user_logged_in() && ! class_exists( 'Woocommerce' ) ) {
        $login_url = esc_url( wp_login_url( home_url() ) );
    }
    else // Logout
    if( is_user_logged_in() ) {
        $login_url = esc_url( wp_logout_url( home_url() ) );
    } ?>
    
    <a class="screen-reader-text skip-link" href="#fury-content">
        <?php esc_html_e( 'Skip to content', 'fury' ); ?>
    </a><!-- .screen-reader-text -->
    
    <!-- Fury Main Wrapper -->
    <div id="fury-main-wrapper" class="fury-main-wrapper">
    
    <?php if( get_theme_mod( 'fury_header_offcanvas_menu', true ) ): ?>
    <div class="offcanvas-container" id="shop-categories">
        <div class="offcanvas-header">
            <?php if( class_exists( 'woocommerce' ) ): ?>
                <h3 class="offcanvas-title"><?php _e( 'Shop Categories', 'fury' ); ?></h3>
            <?php else: ?>
                <h3 class="offcanvas-title"><?php _e( 'Side Navigation', 'fury' ); ?></h3>
            <?php endif; ?>
                <a href="#" aria-label="<?php esc_attr_e( 'Close Menu', 'fury' ); ?>" class="offcanvas-close" data-focus=".cats-toggle">X</a>
        </div>
        <nav class="offcanvas-menu" aria-label="<?php esc_attr_e( 'Offcanvas', 'fury' ); ?>" role="navigation">
            <?php 
            /**
             * Off Canvas Menu
             *
             * Initialize off canvas menu.
             * 
             * @since 1.0.0
             */
            do_action( 'fury_off_canvas_menu' ); ?>
        </nav>
    </div><!-- .offcanvas-container -->
    <?php endif; ?>
    
    <div class="offcanvas-container" id="mobile-menu">
        <div class="offcanvas-header">
            <a class="account-link" href="<?php echo get_edit_user_link(); ?>">
                <div class="user-ava">
                    <?php echo get_avatar( get_current_user_id() ); ?>
                </div>
                <div class="user-info">
                    <h6 class="user-name"><?php echo $username; ?></h6>
                    <span class="text-sm text-white opacity-60"><?php echo $email; ?></span>
                </div>
            </a>
            <a href="#" aria-label="<?php esc_attr_e( 'Close Menu', 'fury' ); ?>" class="offcanvas-close" data-focus=".menu-toggle">X</a>
        </div>
        <nav class="offcanvas-menu" aria-label="<?php esc_attr_e( 'Mobile menu', 'fury' ); ?>" role="navigation">
            <?php
            /**
             * Mobile Menu
             *
             * Initialize mobile menu.
             *
             * @since 1.0.0
             */
            do_action( 'fury_menu', 'fury-mobile' ); ?>
        </nav>
    </div><!-- .offcanvas-container -->
    
    <?php if( get_theme_mod( 'fury_header_top_bar', true ) ): ?>
    <div class="topbar">
        <div class="topbar-column">
            
            <?php 
            $socemail = esc_html( get_theme_mod( 'fury_header_top_bar_email', 'johndoe@example.com' ) ); 
            $socphone = esc_html( get_theme_mod( 'fury_header_top_bar_phone', '00 22 159 4421' ) ); ?>
            
            <?php if( $socemail ): ?>
                <a class="hidden-md-down" href="mailto:<?php echo $socemail; ?>">
                    <i class="icon-mail"></i>&nbsp; <?php echo $socemail; ?>
                </a>
            <?php endif; ?>
            
            <?php if( $socphone ): ?>
                <a class="hidden-md-down" href="tel:<?php echo $socphone; ?>">
                    <i class="icon-bell"></i>&nbsp; <?php echo $socphone; ?>
                </a>
            <?php endif; ?>
            
            <?php get_template_part( 'template-parts/social-icons' ); ?>
            
        </div>
        <div class="topbar-column">
            
        </div>
    </div><!-- .topbar -->
    <?php endif; ?>
    
    <header class="navbar<?php fury_header_class(); ?>">
        
        <?php if( get_theme_mod( 'fury_header_search', true ) ): ?>
        <form class="site-search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="text" name="s" placeholder="<?php esc_attr_e( 'Type to search...', 'fury' ); ?>" value="<?php echo get_search_query() ?>">
            <div class="search-tools">
                <button type="button" class="clear-search"><?php esc_html_e( 'Clear', 'fury' ); ?></button>
                <button type="button" class="close-search" aria-label="<?php esc_attr_e( 'Close search', 'fury' ); ?>"><i class="icon-cross"></i></button>
            </div>
        </form><!-- .site-search -->
        <?php endif; ?>
        
        <div class="site-branding">
            <div class="inner">
                
                <?php if( get_theme_mod( 'fury_header_offcanvas_menu', true ) ): ?>
                <a class="offcanvas-toggle cats-toggle" href="#shop-categories" data-toggle="offcanvas"></a>
                <?php endif; ?>
                <a class="offcanvas-toggle menu-toggle" href="#mobile-menu" data-toggle="offcanvas"></a>
                
                <?php do_action( 'fury_logo' ); ?>
                
            </div>
        </div><!-- .site-branding -->
        
        <nav class="site-menu" aria-label="<?php esc_attr_e( 'Horizontal menu', 'fury' ); ?>" role="navigation">
            <?php do_action( 'fury_menu', 'fury-primary' ); ?>
        </nav><!-- .site-menu -->
        
        <div class="toolbar">
            <div class="inner">
                <div class="tools">
                    
                    <?php if( get_theme_mod( 'fury_header_profile', true ) ): ?>
                    <div class="account">
                        <a href="<?php echo esc_url( $user_profile_url ); ?>"></a><i class="icon-head"></i>
                        <ul class="toolbar-dropdown">
                            <li class="sub-menu-user">
                                <div class="user-ava">
                                    <?php echo get_avatar( get_current_user_id() ); ?>
                                </div>
                                <div class="user-info">
                                    <h6 class="user-name"><?php echo $username; ?></h6>
                                    <span class="text-xs text-muted"><?php echo $email ?></span>
                                </div>
                            </li>
                            <li><a href="<?php echo esc_url( $user_profile_url ); ?>"><?php esc_html_e( 'My Account', 'fury' ); ?></a></li>
                            <li class="sub-menu-separator"></li>
                            <li>
                                <a href="<?php echo $login_url; ?>"> 
                                <i class="icon-unlock"></i><?php echo $login_txt; ?></a>
                            </li>
                        </ul>
                    </div><!-- .account -->
                    <?php endif; ?>
                    
                    <?php if( get_theme_mod( 'fury_header_search', true ) ): ?>
                    <div class="search">
                        <a href="#"></a>
                        <i class="icon-search"></i>
                    </div>
                    <?php endif; ?>
                    
                    <?php if( class_exists( 'woocommerce' ) && get_theme_mod( 'fury_header_cart_icon', true ) ): ?>
                    <div class="cart">
                        
                        <a href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'View Cart', 'fury' ); ?>"></a>
                        <i class="icon-bag"></i>
                        <span class="count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                        <span class="subtotal"><?php echo esc_html( strip_tags( WC()->cart->get_cart_total() ) ); ?></span>
                        
                        <?php do_action( 'fury_cart_dropdown' ); ?>
                        
                    </div><!-- .cart -->
                    <?php endif; ?>
                    
                </div>
            </div>
        </div><!-- .toolbar -->
        
    </header><!-- .navbar -->
    
    <!-- Off-Canvas Wrapper -->
    <div class="offcanvas-wrapper">
        <?php 
        /**
         * Header Image
         *
         * Initialize header image.
         *
         * @since 1.0.4
         */
        do_action( 'fury_header_image' );
        
        /**
         * Slider
         *
         * Initialize fury slider.
         *
         * @since 1.1.6
         */
        do_action( 'fury_slider' );
        
        /**
         * Breadcrumb
         *
         * Initialize breadcrumb.
         *
         * 1.0.0
         */
        do_action( 'fury_breadcrumb' );
        
        /**
         * Content Wrapper
         *
         * Initialize content wrapper.
         *
         * @since 1.0.0
         */
        do_action( 'fury_content_wrapper' );
        